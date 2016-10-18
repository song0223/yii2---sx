<?php

namespace common\models;

use common\models\sxhelps\SxHelps;
use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%post}}".
 *
 * @property integer $id
 * @property integer $type
 * @property string $post_meta_id
 * @property string $user_id
 * @property string $title
 * @property string $author
 * @property string $excerpt
 * @property string $image
 * @property string $content
 * @property string $tags
 * @property string $last_comment_time
 * @property string $last_comment_name
 * @property string $view_count
 * @property string $comment_count
 * @property string $favorite_count
 * @property string $like_count
 * @property string $thanks_count
 * @property string $hate_count
 * @property integer $status
 * @property string $order
 * @property string $created_at
 * @property string $updated_at
 */
class Post extends \yii\db\ActiveRecord
{
    const TOPIC_TECHNICAL = 'topic';
    /**
     * 置顶
     */
    const STATUS_TOP = 3;

    /**
     * 推荐
     */
    const STATUS_EXCELLENT = 2;

    /**
     * 发布
     */
    const STATUS_ACTIVE = 1;

    /**
     * 删除
     */
    const STATUS_DELETED = 0;

    /**
     * 草稿
     */
    const STATUS_DRAFT = 4;

    public $type;

    public static function statusMap($key = null){
        $items = [
            self::STATUS_TOP => '置顶',
            self::STATUS_EXCELLENT => '推荐',
            self::STATUS_ACTIVE => '发布',
            self::STATUS_DRAFT => '草稿',
            self::STATUS_DELETED => '删除',
        ];
        return SxHelps::getItems($items,$key);

    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post}}';
    }


    /**
     * @inheritdoc
     */
    public function behaviors(){
        return [
            //作者id
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'user_id',
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => 'user_id',
                ],
            ],
            //标签
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => 'tags',
                    self::EVENT_BEFORE_UPDATE => 'tags',
                ],
                'value' => function($event){
                    if(!empty($this->tags)){
                        return $this->addTags($this->tags);
                    }else{
                        return false;
                    }
                }
            ],
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
            [['post_meta_id', 'user_id', 'view_count', 'comment_count', 'favorite_count', 'like_count', 'thanks_count', 'hate_count', 'status', 'order', 'updated_at','last_comment_time'], 'integer'],
            [['content'], 'required'],
            [['content','type'], 'string'],
            [['title'], 'string', 'max' => 150],
            [['author','last_comment_time'], 'string', 'max' => 100],
            [['excerpt'], 'string', 'max' => 255],
            [['image'], 'string', 'max' => 200],
            [['tags','created_at'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', '类型'),
            'post_meta_id' => Yii::t('app', '板块id'),
            'user_id' => Yii::t('app', '作者id'),
            'title' => Yii::t('app', '标题'),
            'author' => Yii::t('app', '作者'),
            'excerpt' => Yii::t('app', '摘要'),
            'image' => Yii::t('app', '封面图片'),
            'content' => Yii::t('app', '内容'),
            'tags' => Yii::t('app', '标签 用英文逗号隔开'),
            'last_comment_time' => Yii::t('app', '最后回复时间'),
            'last_comment_name' => Yii::t('app', '最后回复人'),
            'view_count' => Yii::t('app', '查看数'),
            'comment_count' => Yii::t('app', '评论数'),
            'favorite_count' => Yii::t('app', '收藏数'),
            'like_count' => Yii::t('app', '喜欢数'),
            'thanks_count' => Yii::t('app', '感谢数'),
            'hate_count' => Yii::t('app', '讨厌数'),
            'status' => Yii::t('app', '状态'),
            'order' => Yii::t('app', '排序 0最大'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '修改时间'),
        ];
    }

    /*
     *  添加标签
     *  @param array tags
     *  @return string
     */
    public function addTags(array $tags){
        $return = false;
        $tagsModel = new PostTag();
        foreach($tags as $v){
            $_tagsMolde = clone $tagsModel;
            $tagRaw = $_tagsMolde->findOne(['name'=>$v]);

            if(!empty($tagRaw)){
                $tagRaw->updateCounters(['count'=>1]);
                $return = true;
            }else{
                $_tagsMolde->setAttributes([
                    'name' => $v,
                    'count' => 1,
                    'meta_id' => $this->post_meta_id
                ]);
                if($_tagsMolde->save()){
                    $return = true;
                }
            }
        }
        if($return){
            return implode(',',$tags);
        }else{
            return false;
        }
    }

    /*
     *  最后回复更新
     *
     */
    public function finalReplyUpdate($username = ''){
            $this->setAttributes([
                'last_comment_time' => time(),
                'last_comment_name' => $username
            ]);
        return $this->save();
    }

    /*
     * 获取板块
     */
    public function getPostMeta(){
        return $this->hasOne(PostMeta::className(),['id' => 'post_meta_id']);
    }


    public static $formName = 'tagsItem'; //设置特殊字段 获取值

    public function getTagsItem(){
        return explode(',',$this->tags);
    }

}
