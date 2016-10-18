<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/8
 * Time: 10:58
 */

namespace backend\modules\post\models;

use Yii;
use common\models\Post;
use common\models\sxhelps\SxHelps;

class Topic extends Post
{
        const TYPE = self::TOPIC_TECHNICAL;

        public function beforeSave($insert){

            if(parent::beforeSave($insert)){
                if($insert){ //插入操作
                    $this->author = Yii::$app->user->identity['username'];
                    $this->last_comment_name = $this->author;
                    $this->last_comment_time = time();
                    $this->type = self::TYPE;
                    $this->view_count = 1;
                }
                $this->created_at = $this->created_at?strtotime($this->created_at):time();
                $this->excerpt = $this->excerpt?:SxHelps::truncate_utf8_string($this->content,200);
                return true;
            }else{
                return false;
            }
        }

}