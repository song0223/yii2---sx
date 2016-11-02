<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Markdown;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
use common\models\PostMeta;
use common\models\User;
use common\models\sxhelps\SxHelps;
use frontend\modules\post\models\Topic;
/* @var $this yii\web\View */
/* @var $model common\models\Post */

$this->title = $model->title;
?>
<div class="col-md-9 topic-view" contenteditable="false" style="">
    <div class="panel panel-default">
        <div class="panel-heading media clearfix">
            <div class="media-body">
                <?= Html::tag('h3', Html::encode($model->title), ['class' => 'media-heading']); ?>
                <div class="info">
                    <?= Html::a(
                        PostMeta::getNameByid($model->post_meta_id),
                        ['/post/default/index', 'meta_id' => $model->post_meta_id],
                        ['class' => 'node']
                    ) ?>
                    ·
                    <?= Html::a($model->user->username, Url::to(['/user/default/index','username'=>$model->user->username]),[]) ?>
                    ·
                    于 <?= Html::tag('abbr', SxHelps::get_timejq($model->created_at), ['title' => date('Y-m-d H:i:s',$model->created_at)]) ?>发布
                    ·
                    <?= $model->view_count ?> 次阅读
                </div>
            </div>
            <div class="avatar media-right">
                <?= Html::a(Html::img($model->user->userAvatar, ['class' => 'media-object avatar-48']),
                    Url::to(['/user/default/index','username'=>$model->user->username])
                ); ?>
            </div>
        </div>
        <div class="panel-body article">
            <?= HtmlPurifier::process(\yii\helpers\Markdown::process($model->content, 'gfm')) ?>
            <?php if ($model->status == 2): ?>
                <div class="ribbon-excellent">
                    <i class="fa fa-trophy excellent"></i> 本帖已被设为精华帖！
                </div>
            <?php endif ?>
        </div>
        <div class="panel-footer clearfix opts">
            <?php
            $like = Html::a(
                Html::tag('i', '', ['class' => 'fa fa-thumbs-o-up']) . ' ' . Html::tag('span', $model->like_count) . ' 个赞',
                'javascript:void(0)',
                [
                    'data-do' => 'like',
                    'data-id' => $model['id'],
                    'data-type' => Topic::TYPE,
                    'class' => ($model->like) ? 'active': ''
                ]
            );
            $hate = Html::a(
                Html::tag('i', '', ['class' => 'fa fa-thumbs-o-down']) . ' 踩',
                'javascript:void(0)',
                [
                    'data-do' => 'hate',
                    'data-id' => $model['id'],
                    'data-type' => Topic::TYPE,
                    'class' => ($model->hate) ? 'active': ''
                ]
            );
            $follow = Html::a(
                Html::tag('i', '', ['class' => 'fa fa-eye']) . ' 关注',
                'javascript:void(0)',
                [
                    'data-do' => 'follow',
                    'data-id' => $model['id'],
                    'data-type' => Topic::TYPE,
                    'class' => ($model->follow) ? 'active': ''
                ]
            );
            $thanks = Html::a(
                Html::tag('i', '', ['class' => 'fa fa-heart-o']) . ' 感谢',
                'javascript:void(0)',
                [
                    'data-do' => 'thanks',
                    'data-id' => $model['id'],
                    'data-type' => Topic::TYPE,
                    'class' => ($model->thanks) ? 'active': ''
                ]
            );
            $favorite = Html::a(
                Html::tag('i', '', ['class' => 'fa fa-bookmark']) . ' 收藏',
                'javascript:void(0)',
                [
                    'data-do' => 'favorite',
                    'data-id' => $model['id'],
                    'data-type' =>  Topic::TYPE,
                    'class' => ($model->favorite) ? 'active': ''
                ]
            );

            if($model->isOneself()){
                echo Html::a(
                    Html::tag('i', '', ['class' => 'fa fa-thumbs-o-up']) . ' ' . Html::tag('span', $model->like_count) . ' 个赞',
                    'javascript:;'
                );
            } else {
                echo $like, $hate;
                echo $thanks;
            }
            //echo $follow;
            echo $favorite;
            ?>
            <?php
            if(User::isSuperAdmin()) {
                $class = $model->status == 2 ? ['class' => 'active'] : null;
                echo Html::a(
                    Html::tag('i', '', ['class' => 'fa fa-trophy']) . ' 加精',
                    ['/post/default/excellent', 'id' => $model->id],
                    $class
                );
            }
            ?>
            <?php if ($model->isOneself() || User::isSuperAdmin()): ?>
                <span class="pull-right">
                        <?= Html::a(
                            Html::tag('i', '', ['class' => 'fa fa-pencil']) . ' 修改',
                            ['/post/default/update', 'id' => $model->id]
                        ) ?>
                        <?php if($model->comment_count == 0): ?>
                            <?= Html::a(
                                Html::tag('i', '', ['class' => 'fa fa-trash']) . ' 删除',
                                ['/post/default/delete', 'id' => $model->id],
                                [
                                    'data' => [
                                        'confirm' => "您确认要删除文章「{$model->title}」吗？",
                                        'method' => 'post',
                                    ],
                                ]
                            ) ?>
                        <?php endif?>
                    </span>
            <?php endif ?>
        </div>
    </div>
    <?= $this->render(
        '@frontend/modules/post/views/comment/comment',
        ['model' => $model, 'dataProvider' => $dataProvider]
    ) ?>

    <?= $this->render(
        '@frontend/modules/post/views/comment/create',
        ['model' => $comment, 'dataProvider' => $dataProvider]
    )?>
</div>