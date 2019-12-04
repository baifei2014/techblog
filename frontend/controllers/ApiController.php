<?php
namespace frontend\controllers;

use Yii;
use common\models\ScheduleModel;
use common\models\Artical;

/**
 * Site controller
 */
class ApiController extends BaseController
{
	public $enableCsrfValidation = false;

	public function behaviors()
	{
		return [
			'verbs' => [
				'class' => \yii\filters\VerbFilter::className(),
				'actions' => [
					'create'  => ['GET', 'POST'],
				],
			],
		];
	}

	public function actionSchedule()
	{
		$schedules = ScheduleModel::find()
			->where(['is_delete' => 0])
			->orderBy(['create_time' => 'desc'])
			->limit(50)
			->asArray()
			->all();

		return $this->success($schedules);
	}

	public function actionCreate()
	{
		$data = Yii::$app->request->post();

		if (empty($data['title']) || empty($data['url'])) {
			return $this->failed("参数不能为空");
		}

		$schedule = new ScheduleModel;
		$schedule->title = $data['title'];
		$schedule->url = $data['url'];
		$schedule->status = 0;
		$schedule->is_delete = 0;
		$schedule->create_time = date('Y-m-d H:i:s');
		$schedule->update_time = date('Y-m-d H:i:s');
		if ($schedule->save()) {
			Yii::$app->Amqp->publish(
	            'imageCrawl',
	            json_encode(['id' => $schedule->id], JSON_UNESCAPED_SLASHES),
	            [
	                'queue' => 'imageCrawl',
	                'exchange' => 'amq.direct',
	                'exchange_type' => 'direct'
	            ]
	        );
			return $this->success([]);
		}

		return $this->failed('任务创建失败');
	}
}