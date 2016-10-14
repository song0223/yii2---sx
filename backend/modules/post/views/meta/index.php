<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\post\models\search\PostMetaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Post Metas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">
    <div class="box box-primary">
        <div class="box-body">
    <p>
        <?= Html::a(Yii::t('app', 'Create Post Meta'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'name',
                'content' => function($dataProvider){
                    if($dataProvider['parent'] != 0){
                        return '---'.$dataProvider['name'];
                    }else{
                        return $dataProvider['name'];
                    }
                }
            ],
            'alias',
            // 'description',
            'count',
            // 'order',
            // 'created_at',
            // 'updated_at',

            ['class' => 'backend\widgets\grid\ActionWidget'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
        </div>
    </div>
</div>
