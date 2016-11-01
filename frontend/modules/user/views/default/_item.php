<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/1
 * Time: 15:21
 */
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;
use yii\helpers\Url;
use common\models\sxhelps\SxHelps;
use common\models\PostMeta;
?>

<?php
    switch($this->context->action->id){
        case 'post':
            echo Html::a(
                Html::encode($model->title),
                Url::to(['/post/default/view','id' => $model->id]),
                ['class' => 'list-group-item-heading']
            );
            echo Html::tag('span',' '.SxHelps::get_timejq($model->created_at),['class' => 'ml5 fade-info']);
            echo Html::beginTag('p', ['class' => 'list-group-item-text title-info']);
            $node = PostMeta::getNameByid($model->post_meta_id);
            echo Html::a($node, Url::to(['/post/default/index','meta_id' => $model->post_meta_id]));
            echo ' • ';
            echo Html::beginTag('span');
            echo "{$model->like_count} 个赞 • {$model->comment_count} 条回复";
            echo Html::endTag('span');
            echo Html::endTag('p');
            break;

        case 'favorite':
            echo Html::a(
                Html::encode($model->favoritePost->title),
                Url::to(['/post/default/view','id' => $model->favoritePost->id]),
                ['class' => 'list-group-item-heading']
            );
            echo Html::tag('span',' '.SxHelps::get_timejq($model->favoritePost->created_at),['class' => 'ml5 fade-info']);
            echo Html::beginTag('p', ['class' => 'list-group-item-text title-info']);
            $node = PostMeta::getNameByid($model->favoritePost->post_meta_id);
            echo Html::a($node, Url::to(['/post/default/index','meta_id' => $model->favoritePost->post_meta_id]));
            echo ' • ';
            echo Html::beginTag('span');
            echo "{$model->favoritePost->like_count} 个赞 • {$model->favoritePost->comment_count} 条回复";
            echo Html::endTag('span');
            echo Html::endTag('p');
            break;

        default:
            echo Html::a(
                Html::encode($model->post['title']),
                Url::to(['/post/default/view','id' => $model->id]),
                ['class' => 'list-group-item-heading']
            );
            echo Html::tag('span',' '.SxHelps::get_timejq($model->created_at),['class' => 'ml5 fade-info']);
            echo Html::tag('p',HtmlPurifier::process(Markdown::process($model->comment, 'gfm')));
            break;
    }
?>