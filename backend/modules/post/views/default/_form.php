<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use ijackua\lepture\Markdowneditor;
use kartik\select2\Select2;
use common\models\PostMeta;
use common\models\PostTag;
use common\models\Post;
use kartik\widgets\DateTimePicker;
use common\widgets\SelectInput;

/* @var $this yii\web\View */
/* @var $model backend\modules\post\models\Topic */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="topic-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="col-lg-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#tab_1" data-toggle="tab" aria-expanded="true">信息</a>
                </li>
            </ul>
            <div class="tab-content">
                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'post_meta_id')->widget(Select2::classname(), [
                    'data' => PostMeta::getClassifying(),
                    'options' => ['placeholder' => '请选择分类 ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>

                <?= $form->field($model, 'excerpt')->textarea(['rows'=>'6','placeholder' => '不填默认为内容前200个字符']) ?>

                <?= Markdowneditor::widget([
                    'model' => $model,
                    'attribute' => 'content',
                    'leptureOptions' => [
                        'toolbar' => false
                    ]
                ])
                ?>
            </div>
        </div>
</div>
    <div class="col-lg-3">
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
        <?= $form->field($model, 'created_at')->widget(DateTimePicker::className(),[
            'options' => [
                'placeholder' => '选择时间',
                'value' => !empty($model->created_at) ? date('Y-m-d H:i:s', $model->created_at) : ''
            ],
            'pluginOptions' => ['autoclose' => true],
        ]) ?>
        <?= $form->field($model, 'image')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'status')->radioList(Post::statusMap())->label(false) ?>

        <?= $form->field($model, 'view_count')->textInput(['maxlength' => true]) ?>

        <div class="box box-widget">
            <div class="box-header with-border">
                <h3 class="box-title">标签(可选)</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body " style="display: block;">
                <ul class="sortable" data-domain="1" data-sortable-id="1" aria-dropeffect="move">
                </ul>
                <?= $form->field($model,'tags')->widget(SelectInput::className()) ?>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
