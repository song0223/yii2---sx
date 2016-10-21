<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/20
 * Time: 16:21
 */
namespace frontend\modules\post\models;
use common\models\Post;
use common\models\sxhelps\SxHelps;
use common\services\UserService;
use Yii;

class Topic extends Post
{
    const TYPE = Post::TOPIC_TECHNICAL;

    //public $scenario = 'topic';

    public function scenarios(){
        $parent = parent::scenarios();
        $parent['topic'] = ['title','post_meta_id','content','tags'];
        return $parent;
    }

    public function getLike(){
        $model = new UserService();
        return $model->userAction(self::TYPE, 'like', $this->id);
    }

    public function getThanks(){
        $model = new UserService();
        return $model->userAction(self::TYPE, 'thanks', $this->id);
    }

    public function getHate(){
        $model = new UserService();
        return $model->userAction(self::TYPE, 'hate', $this->id);
    }

    public function getFollow(){
        $model = new UserService();
        return $model->userAction(self::TYPE, 'follow', $this->id);
    }

    public function getFavorite(){
        $model = new UserService();
        return $model->userAction(self::TYPE, 'favorite', $this->id);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($insert){//插入操作
                $this->type = self::TYPE;
                $this->author = Yii::$app->user->identity['username'];
                $this->last_comment_name = $this->author;
                $this->last_comment_time = time();
                $this->excerpt = SxHelps::truncate_utf8_string($this->content,200);
            }
            return true;
        } else {
            return false;
        }
    }
}