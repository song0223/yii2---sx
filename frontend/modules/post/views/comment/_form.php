<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\postComment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="list-group-item">

    <?php $form = ActiveForm::begin([
        'action' => '/post/comment/create?id='.Yii::$app->request->getQueryParam('id'),
        'id' => Yii::$app->request->getQueryParam('id')
    ]); ?>

    <?= $form->field($model, 'comment')->textarea([
        'placeholder' => '内容',
        'id' => 'md-input',
        'disabled' => Yii::$app->user->getIsGuest(),
        'data-at-floor' => true,
        'rows' => 6])
        ->label(false)
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
