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
    /**
     * 查询所有文章并按年份归档
     */
    public static function getArticalsByDate()
    {
        $articals = Artical::find()->asArray()->with('author')->orderBy('created_at desc')->all();
        $yearList = [];
        $articalList = [];
        foreach ($articals as $key => $artical) {
            $year = date('Y', $artical['created_at']);
            if(!in_array($year, $yearList)){
                $yearList[] = $year;
                $articalList[$year] = [];
            }
            $articalList[$year][] = $artical;
        }
        return [
            'yearList' => $yearList,
            'articalList' => $articalList,
        ];
    }
}
