<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\postComment */

$this->title = Yii::t('app', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Post Comments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="post-comment-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
