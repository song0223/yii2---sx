<?php

namespace common\models;

use common\models\sxhelps\SxHelps;
use Yii;
use yii\behaviors\TimestampBehavior;
use frontend\modules\post\models\Topic;
/**
 * This is the model class for table "{{%post_comment}}".
 *
 * @property integer $id
 * @property string $post_id
 * @property string $user_id
 * @property string $parent
 * @property string $comment
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 * @property string $like_count
 * @property string $ip
 *
 * @property Topic $topic
 */
class PostComment extends \yii\db\ActiveRecord
{

    const DELETE_T = 0;
    const ACTIVE_T = 1;
    public static function statuMap($key = null){
        $item = [
            self::ACTIVE_T => '正常',
            self::DELETE_T => '删除',
        ];
        return SxHelps::getItems($item ,$key);
    }

    public function behaviors(){
        return [
            TimestampBehavior::className(),
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post_comment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'user_id', 'comment'], 'required'],
            [['post_id', 'user_id', 'parent', 'status', 'created_at', 'updated_at', 'like_count'], 'integer'],
            [['comment'], 'string'],
            [['ip'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => '帖子id',
            'user_id' => '用户',
            'parent' => '父级评论',
            'comment' => '内容',
            'status' => '状态',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'like_count' => '喜欢数',
            'ip' => 'Ip',
        ];
    }

    /**
     * 获取帖子下的所有回复
     * @param $pid
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getCommentByPid($pid){
        return self::find()->where(['post_id'=>$pid])->all();
    }

    public function getUser(){
        return self::hasOne(User::className(),['id'=>'user_id']);
    }

    public function afterSave($insert,$changedAttributes){

    }
}
