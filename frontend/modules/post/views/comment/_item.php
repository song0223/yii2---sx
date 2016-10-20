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
                 $operation = Html::a('','#',['class'=>'fa fa-pencil','title'=>'修改回帖']).
                     Html::a('','#',['class'=>'fa fa-trash','title'=>'删除评论']);
                 echo Html::tag('span',
                        Html::a('<i class="fa fa-thumbs-o-up"></i> <span>'.$model->like_count.'</span> 个赞','#').
                        $operation
                    ,['class'=>'opts pull-right']);
            ?>
        </div>
        <div class="media-body markdown-reply content-body">
            <?= HtmlPurifier::process(Markdown::process($model->comment, 'gfm')) ?>
        </div>
    </div>
    <?php endif;?>




