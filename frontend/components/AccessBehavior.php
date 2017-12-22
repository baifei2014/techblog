<?php 
namespace frontend\components;

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
		AccesslogForm::insertlog();
	}
}