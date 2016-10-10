<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/8
 * Time: 10:58
 */

namespace backend\modules\post\models;


use common\models\Post;

class Topic extends Post
{
        public $type = 'topic';
}