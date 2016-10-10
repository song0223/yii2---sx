<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\post\models\Topic */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Topic',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Topics'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="topic-update">


    <?= $this->render('_form', [
        'model' => $model,
        'type'  => 'update'
    ]) ?>

</div>
