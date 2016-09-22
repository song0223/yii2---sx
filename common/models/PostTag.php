<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%post_tag}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $count
 * @property string $meta_id
 * @property string $created_at
 * @property string $updated_at
 */
class PostTag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post_tag}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['count', 'meta_id', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', '名称'),
            'count' => Yii::t('app', '计数'),
            'meta_id' => Yii::t('app', '分类ID'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '修改时间'),
        ];
    }


    /*
     * 获取分类下的标签
     * @param number meta 分类
     * @return array
     */
    public static function getTagsByMeta($meta,$type = null){
        if($type == 'update'){
            return ArrayHelper::map(
                self::find()->where(['meta_id'=>$meta])->all(),'name','name'
            );
        }
        $tags = ArrayHelper::map(
            self::find()->where(['meta_id'=>$meta])->all(),'id','name'
        );
        $options = '';
        foreach($tags as $k=>$v){
            $options .= "<option value=$k>$v</option>";
        }
        return $options;
    }
}
