<?php

namespace frontend\modules\User\models;

use common\models\User;
use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class AccountForm extends Model
{
    public $email;
    public $username;
    public $tagline;
    public $new_password;
    public $current_password;
    private $_user;

    public function __construct(){
        $this->setAttributes([
            'email' => $this->user->email,
            'username' => $this->user->username,
            'tagline' => $this->user->tagline,
        ]);
        parent::__construct();
    }

    public function getUser(){
        if($this->_user == null){
            $this->_user = Yii::$app->user->identity;
        }
        return $this->_user;
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'required'],
            ['email', 'email'],
            [['new_password', 'current_password','tagline'],'safe'],
            ['current_password', function($attribute){
                if (!\Yii::$app->security->validatePassword($this->$attribute, $this->user->password_hash)) {
                    $this->addError($attribute, '当前密码输入错误');
                }
            }],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'email' => '邮箱',
            'tagline' => '一句话简介',
            'new_password' => '新密码',
            'current_password' => '当前密码',
        ];
    }

    public function save(){
        if (!$this->validate()) {
            return null;
        }

        $this->user->username = $this->username;
        // 新密码没填写 则为不修改密码
        ($this->new_password) ? $this->user->password = $this->new_password : '';
        $this->user->tagline = $this->tagline;
        return $this->user->save();
    }
}
