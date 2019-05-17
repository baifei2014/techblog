<?php 
namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\helpers\im\WebSocketServer;

class WebsocketController extends Controller
{
    public function actionRun()
    {
        $server = new WebSocketServer();
        $server->start();
    }
}