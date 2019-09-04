<?php 
namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\Accesslog;

class OfflineController extends Controller
{
    public function actionIndex()
    {
        Yii::$app->Amqp->consume('webAccessRecord', function ($message, $resolver) {
        	$accessInfo = json_decode($message->body, true);

        	$clientIp = $accessInfo['clientIp'];
        	$accessTime = $accessInfo['accessTime'];

        	$ipInfo = $this->getIpInfo($clientIp);

        	$accessLog = new Accesslog;
        	$accessLog->ip = $clientIp;
        	$accessLog->origin = $ipInfo;
        	$accessLog->access_time = $accessTime;
        	$accessLog->save();

            $resolver->acknowledge($message);
            echo "哈哈";
        }, [
            'timeout' => 3,
            'vhost'   => 'com.likecho.www',
            'routing' => 'webAccessRecord',
            'exchange' => 'amq.direct',
            'exchange_type' => 'direct'
        ]);
        return 0;
    }

    public function actionList()
    {
    	echo "你好\n";
    }

    private function getIpInfo($ip)
	{
		if($ip == '127.0.0.1'){
			return '内网IP';
		}
		$url = 'http://ip.taobao.com/service/getIpInfo.php?ip=' . $ip;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$jsondata = curl_exec($ch);
		curl_close($ch);
		$result = json_decode($jsondata, true);
		if($result['code'] == 1){
			return;
		}
		$data = $result['data'];
		$info = $data['country'] . $data['region']. $data['city'];
		return $info;
	}
}


