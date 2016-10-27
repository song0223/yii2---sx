<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/25
 * Time: 15:21
 */

namespace common\components;


use common\models\sxhelps\ReturnUrl;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use Yii;
class Controller extends \yii\web\Controller
{

    public $_user_id;
    public $_user_name;

    public function init(){
        parent::init();
        $this->_user_id = Yii::$app->user->id;
        $this->_user_name = Yii::$app->user->identity->username;
    }

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'returnUrl' => [
                'class' => ReturnUrl::className(),
                //'uniqueIds' => ['site/qrcode', 'site/login', 'user/security/auth', 'site/reset-password']
            ]
        ]);
    }

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * 返回数据
     * @param $msg
     * @param $type
     * @return array
     */
    public function message($msg, $type){
        $data = [
            'type' => $type,
            'message' => $msg
        ];
        if(Yii::$app->request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
        }
        return $data;
    }
}