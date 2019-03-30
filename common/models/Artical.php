<?php

namespace common\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "artical".
 *
 * @property integer $id
 * @property string $title
 * @property string $summary
 * @property string $text
 * @property integer $user_id
 * @property integer $create_time
 * @property integer $update_time
 */
class Artical extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'artical';
    }

    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text'], 'string'],
            [['user_id'], 'integer'],
            [['title', 'summary'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'summary' => 'Summary',
            'text' => 'Text',
            'user_id' => 'User ID'
        ];
    }
}
