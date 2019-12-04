<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;

/**
 * Site controller
 */
class BaseController extends Controller
{
	public function success(array $data = [], string $msg = 'success', int $code = 0)
    {
        $responseData = [
            'code' => (Int)$code,
            'msg'  => (String)$msg,
            'data' => (Object)$data
        ];

        $response = Yii::$app->response;
		$response->format = \yii\web\Response::FORMAT_JSON;
		$response->data = $responseData;
		$response->send();
    }

    public function failed(string $msg = 'failed', array $data = [], int $code = 400)
    {
        return $this->success($data, $msg, $code);
    }
}