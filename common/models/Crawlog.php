<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "crawlog".
 *
 * @property integer $id
 * @property integer $created_at
 */
class Crawlog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'crawlog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
        ];
    }
}
