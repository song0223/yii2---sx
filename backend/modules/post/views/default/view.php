<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\post\models\Topic */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Topics'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="topic-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
            'post_meta_id',
            'user_id',
            'title',
            'author',
            'excerpt',
            'image',
            'content:ntext',
            'tags',
            'last_comment_time',
            'last_comment_name',
            'view_count',
            'comment_count',
            'favorite_count',
            'like_count',
            'thanks_count',
            'hate_count',
            'status',
            'order',
            'created_at',
            'updated_at',
            'type',
        ],
    ]) ?>

</div>
