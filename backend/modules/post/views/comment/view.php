<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Post;
use common\models\User;
use common\models\PostComment;
/* @var $this yii\web\View */
/* @var $model common\models\postComment */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Post Comments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-comment-view">

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'post_id',
                'content' => function($dataProvider){
                    $model =  Post::getPostById($dataProvider['post_id']);
                    return $model->title;
                }
            ],
            [
                'attribute' => 'user_id',
                'content' => function($dataProvider){
                    $model = User::findIdentity($dataProvider['user_id']);
                    return $model->username;
                }
            ],
            'parent',
            'comment:ntext',
            [
                'attribute' => 'status',
                'content' => function($dataProvider){
                    return PostComment::statuMap($dataProvider['status']);
                },
            ],
            'like_count',
            'ip',
            'created_at:dateTime',
            'updated_at:dateTime',
        ],
    ]) ?>

</div>
