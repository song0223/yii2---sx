<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/21
 * Time: 15:08
 */

namespace common\services;


use common\models\UserMeta;
use Yii;
class UserService
{

        public static function userAction($type,$action, $id){
            return UserMeta::find()
                ->where([
                    'target_type'=> $type,
                    'type' => $action,
                    'target_id' => $id,
                    'user_id' => Yii::$app->user->id
                ])
                ->select(['id'])
                ->scalar();
        }
}