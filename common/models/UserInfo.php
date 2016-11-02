<?php

namespace common\models;

use common\components\ActiveRecord;
use Yii;

/**
 * This is the model class for table "{{%user_info}}".
 *
 * @property string $id
 * @property string $user_id
 * @property string $website
 * @property string $company
 * @property string $location
 * @property string $view_count
 * @property string $comment_count
 * @property string $post_count
 * @property string $thanks_count
 * @property string $like_count
 * @property string $hate_count
 * @property string $login_count
 * @property string $prev_login_time
 * @property string $prev_login_ip
 * @property string $session_id
 * @property string $created_at
 * @property string $github
 * @property string $info
 */
class UserInfo extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_info}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'prev_login_time', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'view_count', 'comment_count', 'post_count', 'thanks_count', 'like_count', 'hate_count', 'login_count', 'prev_login_time', 'created_at', 'updated_at'], 'integer'],
            [['website', 'company', 'location'], 'string', 'max' => 50],
            [['prev_login_ip'], 'string', 'max' => 32],
            [['session_id'], 'string', 'max' => 100],
            [['github','info'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户id',
            'website' => '个人主页',
            'info' => '个人简介',
            'company' => '公司',
            'location' => '城市',
            'github' => 'GitHub帐号',
            'view_count' => '主页浏览数',
            'comment_count' => '评论数',
            'post_count' => '文章数',
            'thanks_count' => '被感谢数',
            'like_count' => '被喜欢数',
            'hate_count' => '被踩数',
            'login_count' => '登入数',
            'prev_login_time' => '上次登入时间',
            'prev_login_ip' => '上次登入ip',
            'session_id' => 'Session ID',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }
}
