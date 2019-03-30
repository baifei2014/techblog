<?php 
namespace common\helpers;

use Yii;
use yii\base\Event;
use common\models\Artical;
use common\models\Crawurl;
use common\models\Errorlog;

/**
 * 简单的爬虫程序
 * 此处仅针对美团技术团队博客而言
 */
class Spider
{
    const EVENT_BEFORE_CRAW = 'beforeCraw';
    /**
     * 要爬取的网站
     * @var string
     */
    public $host = 'https://tech.meituan.com';
    /**
     * 执行请求的curl句柄
     * @var resource
     */
    public $ch;
    /**
     * 文章页网址
     * @var array
     */
    public $urls = [];

    public function run()
    {
        Yii::$app->trigger(self::EVENT_BEFORE_CRAW);
        $this->ch = curl_init();
        $this->curlOpt('');
        $domcontent = curl_exec($this->ch);
        curl_close($this->ch);
        $this->getAllUrl($domcontent);
        $this->crawUrl();
    }
    public function getAllUrl($content)
    {
        $this->resolveUrl('');
        $pattern = "/<a class=\"btn btn-primary home-browser-more-btn\" href=(.*?)\>/";
        if(preg_match($pattern, $content, $matchs)){
            $param = $matchs[1];
        }else{
            $param = false;
        }
        $pattern = "/<a aria-label=Next href=(.*?) .*\>/";
        $i = 0;
        while ($param) {
            $this->resolveUrl($param);
            $this->ch = curl_init();
            $this->curlOpt($param);
            $content = curl_exec($this->ch);
            curl_close($this->ch);
            if(preg_match($pattern, $content, $matchs) && $matchs[1] != '#'){
                $param = $matchs[1];
            }else{
                break;
            }
            $i++;
        }
    }

    public function resolveUrl($url)
    {
        $this->ch = curl_init();
        $this->curlOpt($url);
        $content = curl_exec($this->ch);
        curl_close($this->ch);

        $doc = new \DOMDocument('5.0');
        libxml_use_internal_errors(true);
        $doc->loadHTML($content,LIBXML_SCHEMA_CREATE);
        $routes = $doc->getElementsByTagName('a');
        $urls = [];
        foreach ($routes as $key => $value) {
            $link = $value->getAttribute('href');
            if(preg_match("/[\w+\d+\/]*\.html/", $link)){
                $url = $link;
            }
            if(isset($url) && !preg_match('/^\/tags/', $url) && !in_array($url, $this->urls)){
                $this->urls[] = $url;
            }
        }
    }

    public function curlOpt($link, $method = 'GET', $param = null)
    {
        if (preg_match('/^http/', $link)) {
            $url = $link;
        } else {
            $url = $this->host . $link;
        }
        $pattern = "/([\x{4e00}-\x{9fa5}]+)/u";
        $url = preg_replace_callback($pattern, function($str){
            return urlencode($str[1]);
        }, $url);
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, ["X-HTTP-Method-Override: $method"]);
        // 构造提交的数据
        if($param){
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($param));
        }
        // 返回的结果不直接打印在页面上
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true); 

        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, false);
    }
    public function crawUrl()
    {
        $article = [];
        $pattern = "/<span class=m-post-count>/";
        foreach ($this->urls as $key => $url) {
            if(!$this->isCrawed($url)){
                $this->ch = curl_init();
                $this->curlOpt($url);
                $content = curl_exec($this->ch);
                if (!preg_match($pattern, $content, $matchs)) {
                    continue;
                }
                curl_close($this->ch);
                $title = $this->getTitle($content);
                $text = $this->getText($content);
                $create_time = $this->getCreatedTime($content);
                $summary = mb_substr(strip_tags($text), 0, mt_rand(50, 100));
                if($content){
                    $article['title'] = $title;
                    $article['text'] = $text;
                    $article['summary'] = $summary;
                    $article['create_time'] = $create_time;
                    $this->saveArtical($article);
                }
            }
        }
    }
    public function saveArtical($articleInfo = [])
    {
        try {
            $article = new Artical();
            $article->title = $articleInfo['title'];
            $article->text = $articleInfo['text'];
            $article->summary = $articleInfo['summary'];
            $article->create_time = $articleInfo['create_time'];
            $article->user_id = mt_rand(1,3);
            $article->save();
        } catch (yii\db\Exception $e) {
            $errorlog = new Errorlog;
            $errorlog->type = $e->errorInfo[0];
            $errorlog->code = $e->errorInfo[1];
            $errorlog->message = $e->errorInfo[2];
            $errorlog->save();
        }
    }
    public function saveUrl($url)
    {
        try {
            $crawurl = new Crawurl();
            $crawurl->url = $url;
            $crawurl->save();
        } catch (yii\db\Exception $e) {
            $errorlog = new Errorlog;
            $errorlog->type = $e->errorInfo[0];
            $errorlog->code = $e->errorInfo[1];
            $errorlog->message = $e->errorInfo[2];
            $errorlog->save();
        }
    }
    public function getTitle($content)
    {
        $tag = preg_match("/<h1 class=post-title><a.*?>(.*?)<\/a><\/h1>/", $content, $title);
        if($tag){
            return $title[1];
        }
    }
    public function getCreatedTime($content)
    {
        $tag = preg_match("/<span class=m-post-date><i.*?><\/i>(.*?)<\/span>/", $content, $time);
        if($tag){
            $time = str_replace(['年', '月', '日'], '-', $time[1]);
            $time = trim($time, '-');
            return date('Y-m-d H:i:s', strtotime($time));
        }else{
            return date('Y-m-d H:i:s', mt_rand(time()-1000, time()));
        }
    }
    public function getText($content)
    {
        $tag = preg_match("/<div class=content>([\s\S]*?)<\/div>/", $content,$data);
        $text = '暂无内容';
        if($tag){
            $text = $data[1];
            // return preg_replace_callback("/<img src=\"([\s\S]*?)\"([\s\S]*?)>/", function($str){return '<img src="https://tech.meituan.com/'.$str[1].'"'.$str[2].'>';}, $text);
        }
        return $text;
    }
    public function isCrawed($url)
    {
        if (!preg_match('/^http/', $url)) {
            $url = $this->host . $url;
        }
        $crawurl = Crawurl::find()->where(['url' => $url])->one();
        if($crawurl){
            return true;
        }

        $this->saveUrl($url);
    }
}
