<?php 
namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\helpers\Spider;

class SpiderController extends Controller
{
    public function actionIndex()
    {
        $spider = new Spider();
        $spider->run();
    }
}


