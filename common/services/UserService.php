<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/21
 * Time: 15:08
 */

namespace common\services;

use common\models\PostComment;
use common\models\UserInfo;
use common\models\UserMeta;
use Yii;
class UserService
{
        /**
         * 当前用户是否 点赞 收藏 等操作
         * @param $type
         * @param $action
         * @param $id
         * @return bool|false|null|string
         */
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

        /**
         * 用户对帖子的操作
         * @param $model
         * @param $type 类型
         * @param $do 操作
         * @return array
         */
        public function userAddAction($model, $type ,$do){
            $data = [
                'user_id' => Yii::$app->user->id,
                'type' => $do,
                'target_id' => $model->id,
                'target_type' => $type,
                'value' => '1'
            ];
            if(!UserMeta::deleteOne($data)){
                $userMeta = new UserMeta();
                $userMeta->setAttributes($data);
                $result = $userMeta->save();
                if($result){
                    //帖子操作数+1
                    $model::updateAllCounters([$do.'_count' =>1],['id' => $model->id]);
                    if($do != 'favorite'){
                        UserInfo::updateAllCounters([$do.'_count' =>1],['user_id' => $model->user_id]);
                    }
                }
                return [$result, $model];
            }
            $model::updateAllCounters([$do.'_count' =>-1],['id' => $model->id]);
            return [true,null];
        }
}