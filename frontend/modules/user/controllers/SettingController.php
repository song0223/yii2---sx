<?php

namespace frontend\modules\user\controllers;

use common\models\PostComment;
use common\models\User;
use common\components\Controller;
use common\models\UserDonate;
use common\models\UserInfo;
use common\widgets\MessagePrompt;
use frontend\modules\User\models\AccountForm;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use Yii;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Default controller for the `user` module
 */
class SettingController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),//过滤器
                'only' => ['profile','account','donate','avatar'],
                'rules' => [
                    [
                        'actions' => ['profile','account','donate','avatar'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'crop'=>[
                'class' => 'frontend\modules\user\controllers\CropAction',
                'config'=>[
                    'bigImageWidth' => '200',     //大图默认宽度
                    'bigImageHeight' => '200',    //大图默认高度
                    'middleImageWidth'=> '100',   //中图默认宽度
                    'middleImageHeight'=> '100',  //中图图默认高度
                    'smallImageWidth' => '50',    //小图默认宽度
                    'smallImageHeight' => '50',   //小图默认高度
                    //头像上传目录（注：目录前不能加"/"）
                    'uploadPath' => 'uploads/avatar',
                ]
            ]
        ];
    }
    /**
     * 个人资料
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionProfile(){
        $model = $this->findModel($this->_user_id);
        if($model->load(Yii::$app->request->post()) && $model->save()){
            MessagePrompt::setSucMsg('修改成功！');
            return $this->redirect(['profile']);
        }else{
            return $this->render('view',[
                'model' => $model
            ]);
        }
    }

    /**
     * 帐号设置
     * @return string|Response
     */
    public function actionAccount(){
        $model = new AccountForm();

        $this->performAjaxValidation($model);
        if($model->load(Yii::$app->request->post()) && $model->save()){
            MessagePrompt::setSucMsg('修改成功！');
            return $this->refresh();
        }
        return $this->render('account',[
            'model' => $model
        ]);
    }

    /**打赏设置
     * @return string|Response
     */
    public function actionDonate(){
        $model = UserDonate::findOne(['user_id' => $this->_user_id]);
        if(!$model){
            $model = new UserDonate();
        }

        $model->description ? :$model->description = '如果这篇文章对您有帮助，不妨微信小额赞助我一下，让我有动力继续写出高质量的教程。';
        if($model->load(Yii::$app->request->post())){
            if($image = $model->uploadImage()){
                //目录不存在则建立
                \yii\helpers\FileHelper::createDirectory(Yii::$app->basePath . Yii::$app->params['qrCodePath']);
                $model->deleteImage();
                $image->saveAs(Yii::$app->basePath . Yii::$app->params['qrCodePath'] . $model->qr_code);
            }

            $model->user_id = $this->_user_id;
            if($model->save()){
                MessagePrompt::setSucMsg('信息更新成功！');
            }else{
                MessagePrompt::setSucMsg('信息更新失败！');
            }
            return $this->refresh();
        }
        return $this->render('donate',[
            'model' => $model
        ]);
    }

    public function actionAvatar(){
        $model = User::findOne($this->_user_id);
        return $this->render('avatar',[
            'model' => $model
        ]);
    }

    public function findModel($id){
        $model = UserInfo::findOne(['user_id'=>$id]);
        if(!$model){
            throw new NotFoundHttpException('没有该用户');
        }
        return $model;
    }


    /**
     * Performs ajax validation.
     * @param AccountForm $model
     * @throws \yii\base\ExitException
     */
    protected function performAjaxValidation($model)
    {
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            echo json_encode(ActiveForm::validate($model));
            Yii::$app->end();
        }
    }
}
