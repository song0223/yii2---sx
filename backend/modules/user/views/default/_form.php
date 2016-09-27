<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
$isCreate = ($this->context->action->id == 'create')?true:false;
?>

    <div class="col-md-3">
        <div class="box box-solid">
            <div class="box-body no-padding">
                <ul id="w1" class="nav nav-pills nav-stacked">
                    <li class="active"><a href="#"><i class="fa fa-file-text-o"></i> 信息</a></li>
                    <li class=<?=$isCreate?'disabled':''?>><a href="#"><i class="fa fa-user"></i> 账户</a></li>
                    <li class=<?=$isCreate?'disabled':''?>><a href="#"><span class="glyphicon glyphicon-hand-left"></span> 指派</a></li>
                </ul>
            </div>
        </div>
        <?php if(!$isCreate):?>
        <div class="box box-solid">
            <div class="box-body no-padding">
                <ul id="w1" class="nav nav-pills nav-stacked">
                    <li><a href="#"><i class="fa fa-ban "></i> 封禁</a></li>
                    <li>
                        <?= Html::a(
                            Html::tag('i','',['class'=>'fa fa-remove']).
                            Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                            'data' => [
                                'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                'method' => 'post',
                            ],
                        ]) ?>
                    </li>
                </ul>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-body">
                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'username')->textInput() ?>
                <?= $form->field($model, 'password_hash')->textInput() ?>
                <?= $form->field($model, 'email')->textInput() ?>
                <?= $form->field($model, 'role')->radioList(User::role_map()) ?>
                <?= $form->field($model, 'status')->radioList(User::map()) ?>

                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
