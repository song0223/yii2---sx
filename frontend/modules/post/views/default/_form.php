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
$this->registerJs("
    function changeTags(id){
        $.post('get-tags?meta='+id,function(data){
            if(data){
                $('#topic-tags').append(data);
            }else{
                $('#topic-tags').empty();
            }
         });
    }
",$this::POS_END);
?>
<div class="panel-heading">
        发布新话题
</div>
<div class="list-group-item">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true,'placeholder'=>'标题'])->label(false) ?>

        <?= $form->field($model, 'post_meta_id')->widget(Select2::classname(), [
            'data' => PostMeta::getClassifying(),
            'options' => ['placeholder' => '请选择分类 ...','onchange'=>'changeTags($(this).val())'],
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
            ]) ?>
        <?= Select2::widget([
            'id' => 'topic-tags',
            'name' => 'Topic[tags]',
            'value' => $type?explode(',',$model->tags):[], // initial value
            'data' => $type?PostTag::getTagsByMeta($model->post_meta_id,$type):[],
            'maintainOrder' => true,
            'toggleAllSettings' => [
                'selectLabel' => '<i class="glyphicon glyphicon-ok-circle"></i> 选择全部',
                'unselectLabel' => '<i class="glyphicon glyphicon-remove-circle"></i> 删除全部',
                'selectOptions' => ['class' => 'text-success'],
                'unselectOptions' => ['class' => 'text-danger'],
            ],
            'options' => ['placeholder' => '标签(可选)', 'multiple' => true],
            'pluginOptions' => [
                'tags' => true,
                'maximumInputLength' => 10
            ],
        ]);
        ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
</div>