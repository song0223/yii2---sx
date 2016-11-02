<?php

namespace common\models;

use common\components\ActiveRecord;
use common\models\sxhelps\SxHelps;
use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%user_donate}}".
 *
 * @property string $id
 * @property string $user_id
 * @property integer $status
 * @property string $description
 * @property string $qr_code
 * @property string $created_at
 * @property string $updated_at
 */
class UserDonate extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_donate}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['id', 'user_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string', 'max' => 255],
            [['qr_code'], 'file', 'extensions' => 'gif, jpg, png', 'maxSize' => 1024 * 1024 * 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', '用户id'),
            'status' => Yii::t('app', '状态'),
            'description' => Yii::t('app', '描述'),
            'qr_code' => Yii::t('app', '二维码'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '修改时间'),
        ];
    }

    const CLOSE = 1;
    const OPEN = 2;

    public static function statusMap($key=null){
        $map = [
          self::CLOSE => '关闭',
          self::OPEN => '开启',
        ];
        return SxHelps::getItems($map,$key);
    }

    /**
     * 上传图片
     * @return bool|null|UploadedFile
     */
    public function uploadImage(){
        $image = UploadedFile::getInstance($this, 'qr_code');

        if(!$image){
            return false;
        }

        $this->qr_code = Yii::$app->security->generateRandomString() . ".{$image->extension}";
        return $image;
    }

    /**
     * 删除之前的图片
     * @return bool
     */
    public function deleteImage()
    {
        if (!isset($this->oldAttributes['qr_code']) || !$this->oldAttributes['qr_code']) {
            return false;
        }

        $file = \Yii::$app->basePath . \Yii::$app->params['qrCodePath'] . $this->oldAttributes['qr_code'];
        // check if file exists on server
        if (empty($file) || !file_exists($file)) {
            return false;
        }

        // check if uploaded file can be deleted on server
        if (!unlink($file)) {
            return false;
        }

        return true;
    }
}
