<?php
namespace frontend\models;

use Yii;
use common\models\sxhelps\Sxcaptcha;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $repeatPassword;
    //public $verifyCode;
    public $file;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['repeatPassword','compare','compareAttribute'=>'password'],

            //['verifyCode', 'string', 'length' => 4],
            //['verifyCode',Sxcaptcha::className()],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }

    public function attributeLabels(){
        return [
              'username' => Yii::t('app','username'),
              'email' => Yii::t('app','email'),
              'password' => Yii::t('app','password'),
              'repeatPassword' => Yii::t('app','repeatPassword'),
              //'verifyCode' => Yii::t('app','verifyCode'),
        ];
    }
}
