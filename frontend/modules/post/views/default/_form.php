<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use ijackua\lepture\Markdowneditor;
use kartik\select2\Select2;
use common\models\PostMeta;
use common\models\PostTag;

//nezhelskoy\highlight\HighlightAsset::register($this);
/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="panel-heading">
        发布新话题
</div>
<div class="list-group-item">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true,'placeholder'=>'标题'])->label(false) ?>

        <?= $form->field($model, 'post_meta_id')->widget(Select2::classname(), [
            'data' => PostMeta::getClassifying(),
            'options' => ['placeholder' => '请选择分类 ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>

        <?= Markdowneditor::widget([
                'model' => $model,
                'attribute' => 'content',
                'leptureOptions' => [
                    'toolbar' => false
                ]
            ])
        ?>
    <?= $form->field($model,'tags')->widget(\common\widgets\SelectInput::className()) ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
</div>