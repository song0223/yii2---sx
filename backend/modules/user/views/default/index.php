<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\User;
use backend\widgets\grid\GridSearchColumns;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="article-index">
    <div class="box box-primary">
        <div class="box-body">
            <p>
                <?= Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <?php Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'username',
                    //'auth_key',
                    //'password_hash',
                    //'password_reset_token',
                     'email:email',
                    [
                        'attribute' => 'role',
                        'content' => function($dataProvider){
                            return User::role_map($dataProvider['role']);
                        },
                        'filter' => GridSearchColumns::makeDropDownList('UserSearch[role]',$searchModel->role, User::role_map())
                    ],
                    [
                        'attribute' => 'status',
                        'content' => function($dataProvider){
                            return User::map($dataProvider['status']);
                        },
                        'filter' => GridSearchColumns::makeDropDownList('UserSearch[status]',$searchModel->status, User::map())
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' =>  ['date', 'php:Y-m-d H:i:s'],
                        'filter' => GridSearchColumns::makeDatePicker('created_at', $searchModel)
                    ],
                     //'created_at:datetime',
                    // 'updated_at',
                    [
                        'class' => 'backend\widgets\grid\ActionWidget',
                    ],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>