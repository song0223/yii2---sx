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

/* @var $model common\models\post */
?>
<div class="panel-heading">
    <?=$model['title']?>
</div>
        <div class="panel-body tag-cloud">
            <?= Html::a(HtmlPurifier::process(Markdown::process($model['excerpt'], 'gfm')),Url::to(['/post/default/view','id'=>$model['id']])); ?>
        </div>
        <div class="panel-footer" style="background-color: transparent">
                <?= Html::a(
                    Html::tag('span','阅读全文',['class'=>'read-info opts']),
                    Url::to(['/post/default/view','id'=>$model['id']])
                )?>
                <span class="title-info text-right1">
                    <?php
                    echo Html::a($model->postMeta['name'],
                        Url::to(['/post/default/index','meta_id'=>$model->post_meta_id]) ,
                        ['class' => 'node']),'•';
                    echo Html::a($model['author'],
                        Url::to(['/user/default/index','username'=>$model['author']]) ,
                        ['class' => '']),'•';
                    echo Html::tag('span',
                        '最后由' . Html::a($model['last_comment_name'],
                            Url::to(['/user/default/index','username'=>$model['last_comment_name']]),[]) .' 于'.SxHelps::get_timejq($model['last_comment_time']).' 回复'
                    );
                    ?>
                </span>
        </div>

