<?php

namespace common\models;

use Yii;

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
class UserMeta extends \yii\db\ActiveRecord
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
            [['user_id', 'type', 'value', 'target_id', 'target_type', 'created_at'], 'required'],
            [['user_id', 'target_id', 'created_at'], 'integer'],
            [['type', 'value', 'target_type'], 'string', 'max' => 50],
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
}
