<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = Yii::t('app', 'Assigned');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Assigned'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert"
                            aria-hidden="true">
                        &times;
                    </button>
                    信息！请注意这个信息。
                </div>
                <?php ActiveForm::begin() ?>
                    <div class="form-group">
                        <?= Select2::widget([
                            'id' => 'select',
                            'name' => 'User[role]',
                            'value' => ArrayHelper::map($rolesByUser,'name','name'), // initial value
                            'data' => ArrayHelper::map($roles,'name','name'),
                            'options' => ['placeholder' => '选择', 'multiple' => true],
                            'pluginOptions' => [
                                'tags' => false,
                                'maximumInputLength' => 10
                            ],
                        ])?>
                        <?= Html::submitButton(Yii::t('app', 'To update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
