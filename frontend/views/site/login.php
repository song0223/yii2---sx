<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = Yii::t('app','Login');
?>
<div class="site-login">
    <div class="row">
        <div class="col-md-4 col-sm-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?=$this->title?>
                </div>
                <div class="panel-body">
                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                    <?= $form->field($model, 'password')->passwordInput()->label('密码 ('.Html::a(Yii::t('app','resetPwd'),['site/request-password-reset']).')') ?>

                    <?= $form->field($model, 'rememberMe')->checkbox() ?>

                    <div class="form-group">
                        <?= Html::submitButton($this->title, ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>
                </div>
                <div class="panel-footer">
                    <?=Html::a('注册',Url::to('/site/signup'),[])?>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">用其他平台的帐号登录</div>
                <br>
                <div id="w0"><ul class="auth-clients"><li><a class="github auth-link" href="/user/security/auth?authclient=github" title="GitHub" data-popup-width="820" data-popup-height="600"><span class="auth-icon github"></span></a></li></ul></div>        </div>
        </div>
    </div>
</div>
