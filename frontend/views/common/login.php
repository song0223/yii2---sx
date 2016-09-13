<?php
use yii\helpers\Html;
use frontend\assets\AppAsset;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\captcha\Captcha;

//View::registerJs("
//$(function () {
//});
//", View::POS_END);//在jq后面添加js代码
AppAsset::addScript($this,Yii::$app->request->baseUrl."/js/login.js");//在jq后面添加js文件
?>

<?=Html::cssFile('@web/resources/sign/static/css/ui2.css')?>
<div class="modal-login" id="login-modal"> <a class="close-login">×</a>
    <h1><span class="dr">登录</span><span class="zhuc">注册</span></h1>
    <p>社交帐号登录：</p><br />
    <ul class="login-bind-tp">
        <li class="wechat"> <a href="http://sc.chinaz.com"> 使用 微信 登录</a> </li>
        <li class="qweibo"> <a href="http://sc.chinaz.com"> 使用 QQ 登录</a> </li>
        <li class="sina"> <a href="http://sc.chinaz.com"> 使用 微博 登录</a> </li>
    </ul>
    <p>或者使用已有帐号登录：</p>
    <?php $form = ActiveForm::begin([
        'id' => 'form-login',
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'action' => Url::toRoute(['site/login']),
    ]); ?>
        <div class="form-arrow"></div>
        <?= $form->field($model,'username')->textInput(['placeholder'=>'用户名'])->label(false)?>
        <?= $form->field($model,'password')->passwordInput(['placeholder'=>'密码'])->label(false)?>
        <?= Html::submitButton('登录',['class'=>"btn btn-primary btn-block"])?>
        <div class="clearfix"></div>
        <?= $form->field($model, 'rememberMe')->checkbox() ?>
        <div style="color:#999;margin:1em 0">
            <?= Html::a(Yii::t('app','resetPwd'), ['site/request-password-reset']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>

<div class="modal-login" id="signup-modal"> <a class="close-login">×</a>
    <h1><span class="dr">登录</span><span class="zhuc">注册</span></h1>
    <ul class="login-bind-tp">
        <li class="wechat"> <a href="http://sc.chinaz.com"> 使用 微信 登录</a> </li>
        <li class="qweibo"> <a href="http://sc.chinaz.com"> 使用 QQ 登录</a> </li>
        <li class="sina"> <a href="http://sc.chinaz.com"> 使用 微博 登录</a> </li>
    </ul>
    <?php $form = ActiveForm::begin([
        'id' => 'form-signup',
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'action' => Url::toRoute(['site/signup']),
    ]); ?>
    <div class="form-arrow"></div>
    <?= $form->field($sigModel,'username')->textInput(['placeholder'=>'用户名'])->label(false)?>
    <?= $form->field($sigModel,'password')->passwordInput(['placeholder'=>'密码'])->label(false)?>
    <?= $form->field($sigModel, 'repeatPassword')->passwordInput(['placeholder'=>'重复密码'])->label(false) ?>
    <?= $form->field($sigModel, 'email')->textInput(['placeholder'=>'邮箱'])->label(false) ?>
    <?= $form->field($sigModel, 'verifyCode')->widget(Captcha::className(), [
    'template' => '<div class="row"><div class="col-lg-6">{input}</div><div class="col-lg-3">{image}</div></div>',
        'options' => ['placeholder' => '验证码','class' => 'form-control']])->label(false) ?>
    <div class="form-group">
        <?= Html::submitButton('注册', ['class' => 'btn btn-primary btn-block', 'name' => 'signup-button']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<div class="theme-popover-mask"></div>