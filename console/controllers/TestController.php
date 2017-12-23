<?php 
namespace console\controllers;

use Yii;
use yii\console\Controller;
use console\models\Test;

class TestController extends Controller
{
    public function actionIndex()
    {
        $test1 = Test::find()->orderBy('id desc')->limit(1)->one();
        $test = new Test();
        $test->id = $test1+1;
        $test->time = time();
        $test->save();
    }
}        


