<?php 
namespace frontend\models;

use Yii;
use common\models\Accesslog;

class AccesslogForm
{
	public static function insertLog()
	{
		$userIp = Yii::$app->request->getUserIP();

		$ipInfo = self::getIpInfo($userIp);

		$log = new Accesslog;
		$log->ip = $userIp;
		$log->origin = $ipInfo;
		$log->created_at = time();
		$log->save();
	}
	public static function getIpInfo($ip)
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