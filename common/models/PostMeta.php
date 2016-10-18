<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%post_meta}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $parent
 * @property string $alias
 * @property string $type
 * @property string $description
 * @property integer $count
 * @property integer $order
 * @property integer $created_at
 * @property integer $updated_at
 */
class PostMeta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post_meta}}';
    }
    /**
     * @inheritdoc
     */
    public function behaviors(){
        return [
            //自动填充时间
            TimestampBehavior::className(),
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent', 'count', 'order', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['alias', 'type'], 'string', 'max' => 32],
            [['description'], 'string', 'max' => 255],
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
            'parent' => Yii::t('app', '上级分类'),
            'alias' => Yii::t('app', '别名'),
            'type' => Yii::t('app', '类型'),
            'description' => Yii::t('app', '分类描述'),
            'count' => Yii::t('app', '文章数'),
            'order' => Yii::t('app', '排序'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '修改时间'),
        ];
    }

    /*
     * 获取分类
     */
    public static function getClassifying(){
/*        $sql = "SELECT `id`,`name`
                FROM `qrqy_post_meta`
                WHERE `parent`=0";
        $class_ifying = ArrayHelper::map(self::findBySql($sql)->asArray()->all(),'id','name');
        $ddd = [];
        foreach($class_ifying as $k=>$v){
            $sql2 = "SELECT `id`,`name`
                     FROM `qrqy_post_meta`
                     WHERE `parent` = $k";
            $ddd[$v] = ArrayHelper::map(self::findBySql($sql2)->asArray()->all(),'id','name');
        }*/
        $class_ifying = ArrayHelper::map(
            self::find()->where(['parent'=>0])->orWhere(['parent'=>null])->all(),'id','name'
        );
        $classifying = [];
        foreach($class_ifying as $k=>$v){
            $classifying[$v] = ArrayHelper::map(
                self::find()->where(['parent'=>$k])->all(),'id','name'
            );
        }
        return $classifying;
    }


    /**
     * 根据id获取分类名称
     * @param $id
     * @return bool|mixed
     */
    public static function getNameByid($id){
        $user =  self::find()->where(['id'=>$id])->one();
        if($user){
            return $user['name'];
        }
        return false;
    }


    /**
     * 获取分类树 递归排序
     * @param null $tree
     * @param array $result
     * @param int $deep
     * @param string $separator
     * @return array
     */
    public static function getTrees($tree = null, &$result = [], $deep = 0, $separator = '---&nbsp;'){
        if($tree == null){
            $tree = self::build_tree(0);
        }
        $deep++;
        foreach($tree as $list){
            $list['name'] = str_repeat($separator, $deep-1) . $list['name'];
            $result[$list['id']] = $list;
            if (isset($list['childs'])) {
                self::getTrees($list['childs'], $result, $deep, $separator);
            }
        }
        return $result;
    }

    /**
     * 获取子节点
     * @param $data
     * @param $pid
     * @return array
     */
    protected static function findChild(&$data,$pid){
        $array = [];
        foreach($data as $k=>$v){
            if($pid == $v['parent']){
                $array[$k] = $v;
                unset($data[$k]);
            }
        }
        return $array;
    }

    /**
     * 组合数据
     * @param $pid
     * @return array
     */
    protected static function build_tree($pid){
        $data = self::find()->asArray()->all();
        $childs = self::findChild($data,$pid);
        foreach($childs as $key=>$value){
            $rec = self::build_tree($value['id']);
            if($rec != null){
                $childs[$key]['childs'] = $rec;
            }
        }
        return $childs;
    }

    public function afterDelete(){
        return self::deleteAll('parent = :id',[':id'=>$this->id]);
    }

    public static function updateCount($id){
        $model = self::findOne($id);
        return $model->updateCounters(['count'=>1],['id'=>$id]);
    }
}
