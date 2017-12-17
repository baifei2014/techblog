<?php 
namespace frontend\models;

use yii\base\Model;
use common\models\Artical;

class ArticalForm extends Model{
    /**
     * 获取所有文章
     */
	public static function getArticals()
    {
		return Artical::find()->asArray()->orderBy('id desc')->with('author')->all();
	}
    /**
     * 根据文章id查询单个文章
     */
    public static function getArtical($id)
    {
        return Artical::find()->asArray()->where(['id' => $id])->with('author')->one();
    }
}
