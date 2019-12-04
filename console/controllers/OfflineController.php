<?php 
namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\Accesslog;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use frontend\helpers\gateway\gatewayclient\vendor\workerman\gatewayclient\Gateway;
use frontend\helpers\SentMessage;

class OfflineController extends Controller
{
    public function actionScript()
    {
        $roomId = $data['room_id'];
        $user = User::find()->where(['id' => $data['id']])->one();
        $info = [
            'uid' => $user['id'],
            'message' => $data['message'],
            'avatar' => $user['avatar'],
            'nickname' => $user['nickname'],
            'created_at' => time(),
        ];
        SentMessage::sendToGroup($roomId, $info);
    }

    public function actionBind()
    {
        $data = Yii::$app->request->post();
        // 设置GatewayWorker服务的Register服务ip和端口，请根据实际情况改成实际值
        Gateway::$registerAddress = '47.98.130.177:1238';

        // 假设用户已经登录，用户uid和群组id在session中
        // $uid      = Yii::$app->user->identity->id;
        $group_id = $data['id'];
        $client_id = $data['id'];
        // $group_id = $_SESSION['group'];
        // client_id与uid绑定
        // Gateway::bindUid($client_id, $uid);
        // 加入某个群组（可调用多次加入多个群组）
        if(Gateway::joinGroup($client_id, $group_id)) {
            return json_encode([
                'code' => 1,
                'msg' => '连接成功'
            ]);
        }
    }

    public function actionPublish()
    {
        $message = [
            'id' => 1,
            'url' => "https://note.youdao.com/ynoteshare1/index.html?id=5a623956d7133d3ea2dafa3bf56fb500&type=note&from=singlemessage",
            'title' => "眼科特检群微课"
        ];

        // $connection = new AMQPStreamConnection('47.98.130.177', 5672, 'root', 'root@ROOT', 'com.likecho.www');
        // $channel = $connection->channel();
        // $channel->queue_declare('hello', false, false, false, false);

        // $msg = new AMQPMessage('Hello World!');
        // $channel->basic_publish($msg, '', 'hello');
        // Yii::$app->Amqp->bind('Q1', [
        //     'routing' => 'lazy',
        //     'exchange' => 'amq.topic',
        //     'exchange_type' => 'topic'
        // ]);
        // Yii::$app->Amqp->bind('Q2', [
        //     'routing' => 'lazy.pink',
        //     'exchange' => 'amq.topic',
        //     'exchange_type' => 'topic'
        // ]);
        // Yii::$app->Amqp->bind('Q3', [
        //     'routing' => 'lazy.pink.rabbit',
        //     'exchange' => 'amq.topic',
        //     'exchange_type' => 'topic'
        // ]);
        Yii::$app->Amqp->publish(
            'imageCrawl',
            json_encode($message, JSON_UNESCAPED_SLASHES),
            [
                'queue' => 'imageCrawl',
                'exchange' => 'amq.direct',
                'exchange_type' => 'direct'
            ]
        );
    }

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
        }, [
            'timeout' => 3,
            'vhost'   => 'com.likecho.www',
            'routing' => 'webAccessRecord',
            'exchange' => 'amq.direct',
            'exchange_type' => 'direct'
        ]);
        return 0;
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


