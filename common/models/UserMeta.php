<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "{{%user_meta}}".
 *
 * @property string $id
 * @property string $user_id
 * @property string $type
 * @property string $value
 * @property string $target_id
 * @property string $target_type
 * @property string $created_at
 */
class UserMeta extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_meta}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'type', 'value', 'target_id', 'target_type'], 'required'],
            [['user_id', 'target_id', 'created_at'], 'integer'],
            [['type', 'value', 'target_type'], 'string', 'max' => 50],
        ];
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'created_at',
                ],
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'user_id' => '用户id',
            'type' => '操作类型',
            'value' => '值',
            'target_id' => '目标id',
            'target_type' => '目标类型',
            'created_at' => 'Created At',
        ];
    }

    public static function deleteOne($condition){
        $model = self::findOne($condition);
        if($model){
            return $model->delete();
        }
    }
}
