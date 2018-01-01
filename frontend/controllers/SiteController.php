<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\ArticalForm;
use yii\data\Pagination;
use common\models\Artical;
use common\models\Material;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'accessBeavior' => [
                'class' => 'frontend\components\AccessBehavior'
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        // print_r(Yii::$app->params['devicedetect']['isDesktop']);die;
        $query = Artical::find();
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count]);
        $articals = $query->offset($pagination->offset)
                          ->limit($pagination->limit)
                          ->orderBy('created_at desc')
                          ->all();
        return $this->render('index', ['articals' => $articals, 'pagination' => $pagination]);
    }
    /**
     * 查看文章
     */
    public function actionView($aid)
    {
        $artical = ArticalForm::getArtical($aid);
        return $this->render('view', ['artical' => $artical]);
    }
    public function actionUploadimg()
    {
        $imginfo = Yii::$app->request->post();
        if(!$imginfo){
            $result = [
                'status' => 0,
                'message' => '上传失败',
            ];
            return json_encode($result);
        }
        $tag = preg_match('/^data[\s\S]*,([\s\S]*)/', $imginfo['code'], $matchs);
        if($tag){
            $imgname = $this->generateImageName($imginfo['imgname']);
            $filename = 'frontend/web/upload/'.$imgname.'.png';
            file_put_contents('frontend/web/upload/'.$imgname.'.png', base64_decode($matchs[1]));
        }else{
            $result = [
                'status' => 0,
                'message' => '上传失败',
            ];
            return json_encode($result);
        }
        $imagesize = getimagesize($filename);
        if($imagesize[0] < $imagesize[1]){
            $method = 'width';
        }else{
            $method = 'height';
        }
        $material = new Material();
        $material->imgurl = $filename;
        $material->imgname = $imginfo['imgname'];
        $material->created_at = time();
        $material->method = json_encode($method);
        if($material->save()){
            $result = [
                'status' => 1,
                'message' => '上传成功'
            ];
            return json_encode($result);
        }
    }
    public function generateImageName($name)
    {
        $salt = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $str = strtoupper(md5(microtime()) . md5($name));
        $filename = '';
        for ($i=0; $i < 25; $i++) { 
            $filename .= $salt[mt_rand(0, strlen($salt)-1)];
        }
        for ($i=0; $i < 64; $i++) { 
            if(ord($str[$i]) < 65){
                $sed = mt_rand(0, 2);
                if($sed == 0){
                    $filename .= $str[$i];
                }elseif($sed == 1){
                    $filename .= chr((int) $str[$i] + mt_rand(65, 81));
                }elseif($sed == 2){
                    $filename .= chr((int) $str[$i] + mt_rand(97, 113));
                }
            }else{
                $sed = mt_rand(0, 1);
                if($sed == 0){
                    $filename .= $str[$i];
                }elseif($sed == 1){
                    $filename .= chr(ord($str[$i]) + 32);
                }
            }
        }
        return $filename;
    }
    public function actionGetimage()
    {
        $material = Material::find()->select(['imgurl', 'imgname', 'method'])->orderBy('id desc')->asArray()->all();
        if($material){
            $result = [
                'status' => 1,
                'message' => '获取成功',
                'material' => $material
            ];
        }else{
            $result = [
                'status' => 0,
                'message' => '获取失败'
            ];
        }
        return json_encode($result);
    }
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionAchieve()
    {
        if(!Yii::$app->params['devicedetect']['isDesktop']){
            throw new BadRequestHttpException("Error Processing Request", 1);
            
        }
        $articals = ArticalForm::getArticalsByDate();
        return $this->render('achieve', ['year' => $articals['yearList'], 'articals' => $articals['articalList']]);
    }
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionSalon()
    {
        return $this->render('salon');
    }
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }
    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
