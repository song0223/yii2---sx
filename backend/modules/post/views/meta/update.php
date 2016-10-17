<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PostMeta */

$this->title = Yii::t('app', 'Update Post Meta');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Post Metas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="post-meta-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
