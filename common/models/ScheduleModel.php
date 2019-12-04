<?php

namespace common\models;

use Yii;

class ScheduleModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rouse_schedule';
    }

    public static function getDb()
    {
    	return Yii::$app->get('crawl');
    }
}