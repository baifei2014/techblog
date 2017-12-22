<?php 
namespace frontend\models;

use Yii;
use common\models\Accesslog;

class AccesslogForm
{
	public static function insertLog()
	{
		$log = new Accesslog;
		$log->ip = Yii::$app->request->getUserIP();;
		$log->created_at = time();
		$log->save();
	}
}