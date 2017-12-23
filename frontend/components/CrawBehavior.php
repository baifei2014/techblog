<?php 
namespace frontend\components;

use yii\base\Behavior;
use yii\web\Controller;
use common\models\Crawlog;
use common\helpers\Spider;

class CrawBehavior extends Behavior 
{
    public function events()
    {
        return [
            Spider::EVENT_BEFORE_CRAW => 'updateLog'
        ];
    }
    public function updateLog()
    {
        $log = new Crawlog;
        $log->created_at = time();
        $log->save();
    }
}
