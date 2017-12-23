<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "accesslog".
 *
 * @property integer $id
 * @property string $ip
 * @property string $origin
 * @property integer $created_at
 */
class Accesslog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'accesslog_test';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at'], 'integer'],
            [['ip', 'origin'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip' => 'Ip',
            'origin' => 'Origin',
            'created_at' => 'Created At',
        ];
    }
}
