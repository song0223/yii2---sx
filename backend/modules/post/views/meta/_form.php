<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\PostMeta;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\PostMeta */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-meta-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'parent')->dropDownList(ArrayHelper::map(PostMeta::getTrees('', $result,0,'---'),'id','name'),['prompt' => '请选择']) ?>

    <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order')->textInput() ?>

    <?= $form->field($model, 'description')->textarea() ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
