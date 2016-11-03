<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/21
 * Time: 11:39
 */
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;
use yii\helpers\Url;
use common\models\sxhelps\SxHelps;
use frontend\modules\post\models\Topic;
$tag = Yii::$app->request->getQueryParam('tag');
/* @var $model common\models\post */
?>

<div class="list-group-item" data-key=<?=$model->id?>>
    <div class="media">
        <a class="pull-right" href="/topic/23#comment2"><span class="badge badge-reply-count"><?=$model->comment_count?></span></a>
        <div class="media-left">
            <?= Html::a(
                Html::img($model->user->getuserAvatar('small'),['class'=>'media-object']),
                Url::to(['/user/default/index','username'=>$model->user->username])
            );
            ?>
        </div>
        <div class="media-body">
            <div class="media-heading">
                <?php echo Html::a($model['title'],Url::to(['/post/default/view','id'=>$model->id]),['title'=>$model['title']]);
                if($model->status == Topic::STATUS_EXCELLENT){
                    echo Html::tag('i','',['class'=>'fa fa-trophy excellent']);
                }
                ?>
            </div>
            <div class="title-info">
                <?php
                echo Html::a($model->postMeta['name'], '#' , ['class' => 'node']),'•';
                echo Html::a($model['author'], '#' , ['class' => '']),'•';
                echo Html::tag('span',
                    '最后由' . Html::a($model['last_comment_name'],'/member/forecho',[]) .'于 '.SxHelps::get_timejq($model['last_comment_time']).' 回复'
                );
                ?>
            </div>
        </div>
    </div>
</div>
