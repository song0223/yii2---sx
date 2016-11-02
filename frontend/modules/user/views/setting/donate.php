<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/2
 * Time: 13:48
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\UserDonate;
/* @var $this yii\web\View */
/* @var $model common\models\UserDonate */
/* @var $form ActiveForm */
$this->title = '打赏设置';
?>
<section class="container user-index">
    <div class="col-md-3">
        <?= $this->render('_menu') ?>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= Html::encode($this->title) ?>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'id' => 'profile-form',
                    'options'=>['class'=>'form-horizontal','enctype' => 'multipart/form-data'],
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-sm-offset-3 col-lg-9\">{error}\n{hint}</div>",
                        'labelOptions' => ['class' => 'col-lg-3 control-label'],
                    ],
                ]); ?>

                <?php if ($model->qr_code): ?>
                    <div class="form-group">
                        <div class="col-lg-offset-3 col-lg-9">
                            <?= Html::img(Yii::$app->params['qrCodeUrl'] . $model->qr_code, ['class' => 'img']) ?>
                        </div>
                    </div>
                <?php endif ?>

                <?= $form->field($model, 'qr_code')->fileInput() ?>

                <?= $form->field($model, 'status')->dropDownList(UserDonate::statusMap()) ?>

                <?= $form->field($model, 'description')->textarea() ?>

                <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-9">
                        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?><br>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</section>

