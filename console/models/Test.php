<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "test".
 *
 * @property integer $id
 * @property integer $time
 */
class Test extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'time'], 'required'],
            [['id', 'time'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'time' => 'Time',
        ];
    }
}
