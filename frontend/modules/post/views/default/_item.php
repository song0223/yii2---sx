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

/* @var $model common\models\post */
?>
<div class="panel-heading">
    <?=$model['title']?>
        </div>
        <div class="panel-body tag-cloud">
            <?= Html::a(HtmlPurifier::process(Markdown::process($model['excerpt'], 'gfm')),Url::to(['/post/default/view','id'=>$model['id']])); ?>
        </div>
        <div class="panel-footer" style="background-color: transparent">
                <span class="title-info opts">
1
                </span>
                <span class="title-info text-right1">
                    <?php
                    echo Html::a($model->postMeta['name'], '#' , ['class' => 'node']),'•';
                    echo Html::a($model['author'], '#' , ['class' => '']),'•';
                    echo Html::tag('span',
                        '最后由' . Html::a($model['last_comment_name'],'/member/forecho',[]) .'于 '.SxHelps::get_timejq($model['last_comment_time']).' 回复'
                    );
                    ?>
                </span>
        </div>
