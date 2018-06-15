<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "errorlog".
 *
 * @property integer $id
 * @property string $type
 * @property integer $code
 * @property string $message
 */
class Errorlog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'errorlog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code'], 'integer'],
            [['type'], 'string', 'max' => 50],
            [['message'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'code' => 'Code',
            'message' => 'Message',
        ];
    }
}
