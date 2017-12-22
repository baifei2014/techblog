<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "uvlog".
 *
 * @property integer $id
 * @property string $ip
 * @property string $token
 * @property string $device
 * @property integer $created_at
 */
class Uvlog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'uvlog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at'], 'integer'],
            [['ip'], 'string', 'max' => 255],
            [['token'], 'string', 'max' => 1000],
            [['device'], 'string', 'max' => 50],
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
            'token' => 'Token',
            'device' => 'Device',
            'created_at' => 'Created At',
        ];
    }
}
