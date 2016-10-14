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

$this->title = Yii::t('app', 'recycle');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">
    <div class="box box-primary">
        <div class="box-body">

    <p>
        <?= Html::a(Yii::t('app', 'Empty Trash'), ['empty'], [
                'class' => 'btn btn-danger',
                'data' => [
                    'method' => 'post',
                    'confirm' => Yii::t('app', 'Are you sure you want to Empty Trash?')
                ]
            ])
        ?>
    </p>
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',

            'title',
            'author',
            [
                'attribute' => 'updated_at',
                'label' => '删除时间',
                'format' =>  ['date', 'php:Y-m-d H:i:s'],
            ],
            [
                'attribute' => 'status',
                'content' => function($dataProvider){
                    return Topic::statusMap($dataProvider['status']);
                },
            ],
            [
                'class' => 'backend\widgets\grid\ActionWidget',
                'template' => '{:update} {:delete}',
                'buttons' => [
                    'update' => function($url, $model){
                        return Html::a('还原',['recovery'], [
                            'data-ajax' => 1,
                            'data-method' => 'post',
                            'data-params' => ['id' => $model->id],
                            'confirm' => Yii::t('app', 'Are you sure you want to Empty Trash?')

                        ]);
                    },
                    'delete' => function($url, $model){
                        return Html::a('清除', ['clear', 'id'=> $model->id], [
                            'data-ajax' => 1,
                            'data-method' => 'post',
                            'confirm' => Yii::t('app', 'Are you sure you want to Clear this user?')
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
