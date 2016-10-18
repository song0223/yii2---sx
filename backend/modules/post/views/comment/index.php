<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Post;
use common\models\User;
use common\models\PostComment;
use backend\widgets\grid\GridSearchColumns;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\post\models\search\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Post Comments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">
    <div class="box box-primary">
        <div class="box-body">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

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
                'filter' => GridSearchColumns::makeDropDownList('CommentSearch[status]',$searchModel->status,PostComment::statuMap())
            ],
            'created_at:dateTime:创建时间',
            // 'updated_at',
            'like_count',
            // 'ip',

            [
                'class' => 'backend\widgets\grid\ActionWidget',
                'template' => '{:view} {:delete} {:ban}',
                'buttons' => [
                    'ban' => function($url,$model){
                        $url = Url::to(['/user/default/ban','id'=>$model->user_id]);
                        return Html::a('<span class="fa fa-ban"></span>', $url, [
                            'title' => Yii::t('app','Ban'),
                            'class' => 'btn btn-default btn-xs',
                            'data-method' => 'post',
                        ]);
                    }
                ]
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
        </div>
    </div>
</div>
