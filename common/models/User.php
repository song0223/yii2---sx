<?php
namespace common\models;

use common\models\sxhelps\SxHelps;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property string $tagline
 * @property string $role
 * @property integer $notification_count
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 1;
    const STATUS_ACTIVE = 10;
    const USER_BACKEND = 20;
    const USER_FRONTEND = 10;
    const ROLE_SUPER_ADMIN = 30;

    public static function map($key = null){
        $items = [
            self::STATUS_DELETED => '封禁',
            self::STATUS_ACTIVE => '正常'
        ];
        return SxHelps::getItems($items,$key);

    }

    public static function role_map($key = null){
        $items = [
            self::USER_FRONTEND => '普通用户',
            self::USER_BACKEND => '管理员',
            self::ROLE_SUPER_ADMIN => '超级管理员'
        ];
        return SxHelps::getItems($items,$key);

    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],

            ['role', 'default', 'value' => 10],
            ['role', 'in', 'range' => [self::USER_FRONTEND, self::USER_BACKEND, self::ROLE_SUPER_ADMIN]],
            ['email', 'email'],
            [['username','email','password_hash','status','role'],'required'],
            [['notification_count','tagline'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public static function isAdmin($name){
        return self::find()->where(['username'=>$name,'role'=>self::USER_BACKEND])->one() ?true :false;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'username'),
            'auth_key' => Yii::t('app', 'auth_key'),
            'password_hash' => Yii::t('app', 'password'),
            'password_reset_token' => Yii::t('app', 'password_reset_token'),
            'email' => Yii::t('app', 'email'),
            'role' => Yii::t('app', 'Account type'),
            'status' => Yii::t('app', 'Type'),
            'tagline' => '一句话简介',
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }


    public static function isSuperAdmin(){
        //$username = Yii::$app->user->identity->username;
        if(empty(Yii::$app->user->identity->username)){
            return false;
        }
        return self::find()->where(['username'=>Yii::$app->user->identity->username,'role'=>self::USER_BACKEND])->one();
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes){
        $time = time();
        if($insert){
            $userInfo = Yii::createObject([
                'class' => UserInfo::className(),
                'user_id' => $this->id,
                'prev_login_time' => $time,
                'created_at' => $time,
                'updated_at' => $time,
                'prev_login_ip' => Yii::$app->request->getUserIP()?:'127.0.0.1'
            ]);
            $userInfo->save();
        }
        parent::afterSave($insert, $changedAttributes);
    }

    public function getUserInfo(){
        return self::hasOne(UserInfo::className(),['user_id' => 'id']);
    }

    public function getUserAvatar($size = 'middle'){
        if($this->avatar){
            if($size == 'big'){
                return $this->avatar;
            }
            $rule = '/big/';
            if(preg_match($rule,$this->avatar)){
                $msg = preg_replace($rule, $size,$this->avatar);
                return $msg;
            }

        }
        return '/resources/004632511'.$size.'.jpg';
    }
}
