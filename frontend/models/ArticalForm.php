<?php 
namespace frontend\models;

use yii\base\Model;
use common\models\Artical;

class ArticalForm extends Model{
	public static function getArticals(){
		return Artical::find()->asArray()->orderBy('id desc')->with('author')->all();
	}
}