<?php 
namespace frontend\components;

use Yii;
use yii\base\Behavior;
use yii\web\Controller;
use frontend\models\AccesslogForm;

class AccessBehavior extends Behavior 
{
	public function events()
	{
		return [
			Controller::EVENT_BEFORE_ACTION => 'updateLog',
		];
	}
	public function updateLog($event)
	{
		if (YII_ENV == 'development') {
			return;
		}
		$data = [
			'clientIp' => Yii::$app->request->getUserIP(),
			'accessTime' => date('Y-m-d H:i:s')
		];
		Yii::$app->Amqp->publish(
            'webAccessRecord',
            json_encode($data),
            ['exchange' => 'amq.topic', 'exchange_type' => 'topic', 'queue' => 'webAccessRecord']
        );
	}
}