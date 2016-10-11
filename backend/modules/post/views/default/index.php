<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\PostMeta;
use backend\widgets\grid\GridSearchColumns;
use backend\modules\post\models\Topic;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\post\models\search\TopicSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Topics');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">
    <div class="box box-primary">
        <div class="box-body">

    <p>
        <?= Html::a(Yii::t('app', 'Create Topic'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'attribute' => 'post_meta_id',
                'content' => function($dataProvider){
                    return PostMeta::getNameByid($dataProvider['post_meta_id']);
                },
                'filter' => GridSearchColumns::makeDropDownList('TopicSearch[post_meta_id]',$searchModel->post_meta_id,PostMeta::getClassifying())
            ],
            'title',
            'author',
            // 'excerpt',
            // 'image',
            // 'content:ntext',
            // 'tags',
            // 'last_comment_time',
            // 'last_comment_name',
            // 'view_count',
            // 'comment_count',
            // 'favorite_count',
            // 'like_count',
            // 'thanks_count',
            // 'hate_count',
            [
                'attribute' => 'status',
                'content' => function($dataProvider){
                    return Topic::statusMap($dataProvider['status']);
                },
                'filter' => GridSearchColumns::makeDropDownList('TopicSearch[status]',$searchModel->status, Topic::statusMap())
            ],
            // 'order',
            [
                'attribute' => 'created_at',
                'format' =>  ['date', 'php:Y-m-d H:i:s'],
                'filter' => GridSearchColumns::makeDatePicker('created_at', $searchModel)
            ],
            // 'updated_at',
            // 'type',

            [
                'class' => 'backend\widgets\grid\ActionWidget',
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
        </div>
    </div>
</div>
