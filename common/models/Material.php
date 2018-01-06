<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "material".
 *
 * @property integer $id
 * @property string $imgurl
 * @property string $imgname
 * @property integer $created_at
 * @property string $method
 */
class Material extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'material';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at'], 'required'],
            [['created_at'], 'integer'],
            [['imgurl', 'imgname', 'method'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'imgurl' => 'Imgurl',
            'imgname' => 'Imgname',
            'created_at' => 'Created At',
            'method' => 'Method',
        ];
    }
}
