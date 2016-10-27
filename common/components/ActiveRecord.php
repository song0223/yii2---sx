<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/27
 * Time: 15:39
 */

namespace common\components;

use Yii;
use yii\behaviors\TimestampBehavior;

class ActiveRecord extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function behaviors(){
        return [
            //自动填充时间
            TimestampBehavior::className(),
        ];
    }

    public function isOneself(){
        return $this->user_id == Yii::$app->user->id;
    }
}