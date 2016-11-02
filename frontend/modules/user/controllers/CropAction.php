<?php
namespace frontend\modules\user\controllers;

use common\models\User;
use hyii2\avatar\UploadForm;
use Yii;
use yii\base\Action;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;

class CropAction extends \hyii2\avatar\CropAction
{
    
    public function run()
    {
        $model = new UploadForm();
        $user = User::findOne(Yii::$app->user->id);
        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            $post = Yii::$app->request->post();
            $model->avatarData = $post['UploadForm']['avatarData'];
            $model->config = $this->config;
            if ($model->upload()) {
                $user->avatar = $model->imageUrl;
                $user->save();
                // 文件上传成功
                return json_encode(['state'=>200,'message'=>'上传成功！','result'=>$model->imageUrl]);
            }
        }
    }
}