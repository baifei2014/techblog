<?php 
namespace frontend\components;

use yii\base\Controller;
use yii\base\Behavior;

class AccessBehavior extends Behavior 
{
	public function events()
	{
		return [
			Controller::EVENT_BEFORE_ACTION => ''
		];
	}
}