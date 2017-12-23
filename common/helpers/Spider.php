<?php 
namespace common\helpers;

use common\models\Artical;
/**
 * 简单的爬虫程序
 * 此处仅针对美团技术团队博客而言
 */
class Spider
{
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
        $this->ch = curl_init();
        $this->curlOpt('');
        $domcontent = curl_exec($this->ch);
        curl_close($this->ch);
        $this->getAllUrl($domcontent);
        $this->crawUrl();
    }
    public function getAllUrl($content)
    {
        $pattern = "/<span class=\"rectangle\"><a href=\"([\/\?=\w+\d+]*)/";
        $tag = preg_match($pattern, $content, $matchs);
        if($tag){
            $param = $matchs[1];
        }else{
            $param = false;
        }
        while ($param) {
            $this->ch = curl_init();
            $this->curlOpt($param);
            $content = curl_exec($this->ch);
            curl_close($this->ch);
            $tag = preg_match($pattern, $content, $matchs);
            if($tag){
                $param = $matchs[1];
            }else{
                break;
            }
        }

        $this->ch = curl_init();
        $this->curlOpt($param);
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
            if(isset($url) && !in_array($url, $this->urls)){
                $this->urls[] = $url;
            }
        }
    }
    public function curlOpt($link, $method = 'GET', $param = null)
    {
        $url = $this->host . $link;
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
        foreach ($this->urls as $key => $url) {
            $this->ch = curl_init();
            $this->curlOpt($url);
            $content = curl_exec($this->ch);
            curl_close($this->ch);
            $title = $this->getTitle($content);
            $content = $this->getText($content);
            $created_time = $this->getCreatedTime($content);
            $summary = mb_substr(strip_tags($content), 0, mt_rand(50, 100));
            if($content){
                $this->saveArtical($title, $content, $summary, $created_time);
            }
        }
        // echo '<pre>';
        // print_r($articals);die;
    }
    public function saveArtical($title, $text, $summary, $created_time)
    {
        $artical = new Artical;
        $artical->title = $title;
        $artical->text = $text;
        $artical->summary = $summary;
        $artical->user_id = mt_rand(1, 3);
        $artical->created_at = $created_time;
        $artical->updated_at = $created_time;
        $artical->save();
    }
    public function getTitle($content)
    {
        $tag = preg_match("/<h1 class=\"title\">(.*?)<\/h1>/", $content, $title);
        if($tag){
            return $title[1];
        }
    }
    public function getCreatedTime($content)
    {
        $tag = preg_match("/<span class=\"date\">(.*?)<\/span>/", $content, $time);
        if($tag){
            return $time[1];
        }else{
            return mt_rand(1392400562, time());
        }
    }
    public function getText($content)
    {
        $tag = preg_match("/<div class=\"article__content\">([\s\S]*?)<\/div>/", $content,$data);
        if($tag){
            $text = $data[1];
            return preg_replace_callback("/<img src=\"([\s\S]*?)\"([\s\S]*?)>/", function($str){return '<img src="https://tech.meituan.com/'.$str[1].'"'.$str[2].'>';}, $text);
        }
    }
}