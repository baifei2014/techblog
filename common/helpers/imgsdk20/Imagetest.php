<?php
namespace common\helpers\imgsdk20;

require_once __DIR__ . '/index.php';
use Yii;
use QcloudImage\CIClient;

/**
* 图片检测
*/
class Imagetest
{

    public $client;

    public function __construct()
    {
        $appid = Yii::$app->params['APPID'];
        $secretid = Yii::$app->params['SECRETID'];
        $secretket = Yii::$app->params['SECRETKET'];
        $bucket = Yii::$app->params['BUCKET'];

        $this->client = new CIClient($appid, $secretid, $secretket, $bucket);
        $this->client->setTimeout(30);
    }
    public function pornDetect($imgurl1 = null, $imgurl2 = null)
    {
        $result = $this->client->pornDetect(array('urls'=>[$imgurl1, $imgurl2]));
        $result = json_decode($result, true);
        if($result['http_code'] == 200){
            if($result['result_list'][0]['message'] == 'success' && $result['result_list'][1]['message']){
                $data = [];
                $data[0] = [];
                $data[1] = [];
                $data[0]['porn_score'] = $result['result_list'][0]['data']['porn_score'];
                $data[0]['hot_score'] = $result['result_list'][0]['data']['hot_score'];
                $data[1]['porn_score'] = $result['result_list'][1]['data']['porn_score'];
                $data[1]['hot_score'] = $result['result_list'][1]['data']['hot_score'];
                return $data;
            }
        }
    }
    public function faceCompare($imgurl1 = null, $imgurl2 = null)
    {
        $result = $this->client->faceCompare(array('url'=>$imgurl1), array('url'=>$imgurl2));
        $result = json_decode($result, true);
        if($result['http_code'] == 200){
            $similarity = $result['data']['similarity'];
            return $similarity;
        }else{
            return 0;
        }
    }
}

