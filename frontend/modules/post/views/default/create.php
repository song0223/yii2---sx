<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Post */

$this->title = Yii::t('app', 'Create Post');
?>
<div class="col-md-9">
    <div class="panel panel-default">


    <?= $this->render('_form', [
        'model' => $model,
        'type' => null
    ]) ?>
    </div>
</div>
