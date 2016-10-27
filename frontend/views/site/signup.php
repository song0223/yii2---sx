<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Url;

$this->title = '注册';
?>
<div class="site-signup">
    <div class="row">
        <div class="col-md-4 col-sm-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?= Html::encode($this->title) ?>
                </div>
                <div class="panel-body">
                <?php $form = ActiveForm::begin(['id' => 'form-signup','enableAjaxValidation' => true,
                    'enableClientValidation' => false]); ?>

                    <?= $form->field($model, 'username')->textInput(['id'=>'author','autofocus' => true]) ?>

                    <?= $form->field($model, 'password')->passwordInput() ?>

                    <?= $form->field($model, 'repeatPassword')->passwordInput() ?>

                    <?= $form->field($model, 'email') ?>

                    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-lg-6">{input}</div><div class="col-lg-3">{image}</div></div>',
                    ]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('注册', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                    </div>
                <?php ActiveForm::end(); ?>
                </div>
                <div class="panel-footer">
                    <?=Html::a('登录',Url::to('/site/login'),[])?>
                </div>
            </div>
        </div>
    </div>
</div>
