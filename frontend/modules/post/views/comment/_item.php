<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/19
 * Time: 11:40
 */
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;
use common\models\sxhelps\SxHelps;
use common\models\User;
use yii\helpers\Url;
/* @var $model common\models\PostComment */
$index += +1 + $widget->dataProvider->pagination->page * $widget->dataProvider->pagination->pageSize;
?>
    <?php if (!$model->status): ?>
        <div class="deleted text-center"><?= $index ?>楼 已删除.</div>
    <?php else: ?>
    <div class="avatar pull-left">
        <?=
            Html::a(Html::img('dddd'),'member/index');
        ?>
    </div>
    <div class="infos" id="comment<?= $index ?>">
        <div class="media-heading meta info opts">
            <?php echo  Html::a($model->user['username'],'#',['class'=>'author']).'•'.
                 Html::a("#{$index}","#comment{$index}",['class'=>'comment-floor']).'•'.
                 Html::tag('addr',SxHelps::get_timejq($model->created_at),['title'=>date('Y-m-d H:i:s',$model->created_at)]);
                 $operation = Html::tag('span',
                     Html::a('',Url::to(['/post/comment/update','id'=>$model->id]),['class'=>'fa fa-pencil','title'=>'修改回帖']).
                     Html::a('',Url::to(['/post/comment/delete','id'=>$model->id]),
                         [
                             'class'=>'fa fa-trash','title'=>'删除评论',
                             'data' => [
                                 'method' => 'post',
                                 'confirm' => Yii::t('app', 'Are you sure you want to delete this?')
                             ]
                         ]
                     ),
                     ['class'=>'opts pull-right']
                 );
                if ($model->isOneself() || User::isSuperAdmin()){
                    echo $operation;
                }
                echo Html::a(
                    Html::tag('i', '', ['class' => 'fa fa-thumbs-o-up']) . ' ' . Html::tag('span', $model->like_count) . ' 个赞',
                    'javascript:void(0)',
                    [
                        'data-do' => 'like',
                        'data-id' => $model['id'],
                        'data-type' => $model::TYPE,
                        'class' =>(($model->like) ? 'active': '').' opts pull-right'
                    ]
                );
            ?>
        </div>
        <div class="media-body markdown-reply content-body">
            <?= HtmlPurifier::process(Markdown::process($model->comment, 'gfm')) ?>
        </div>
    </div>
    <?php endif;?>




