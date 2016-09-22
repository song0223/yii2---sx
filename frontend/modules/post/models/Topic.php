<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/20
 * Time: 16:21
 */
namespace frontend\modules\post\models;
use common\models\Post;

class Topic extends Post
{
    const TYPE = 'topic';

    //public $scenario = 'topic';

    public function scenarios(){
        $parent = parent::scenarios();
        $parent['topic'] = ['title','post_meta_id','content','tags'];
        return $parent;
    }
}