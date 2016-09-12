<?php
use yii\helpers\Html;
use frontend\assets\AppAsset;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

View::registerJs("
$(function () {
    $('#login-class').click(function(){
        $('.theme-popover-mask').fadeIn(100);
        $('#login-modal').slideDown(250);
    });
    $('#login-modal .close-login').click(function(){
        $('.theme-popover-mask').fadeOut(100);
        $('#login-modal').slideUp(200);
    });
});
", View::POS_END);//在jq后面添加js代码
//AppAsset::addScript($this,Yii::$app->request->baseUrl."/css/main.js");//在jq后面添加js文件
?>

<?=Html::cssFile('@web/resources/sign/static/css/ui2.css')?>
<div class="modal-login" id="login-modal"> <a class="close-login">×</a>
    <h1>登录</h1>
    <p>社交帐号登录：</p><br />
    <ul class="login-bind-tp">
        <li class="wechat"> <a href="http://sc.chinaz.com"> 使用 微信 登录</a> </li>
        <li class="qweibo"> <a href="http://sc.chinaz.com"> 使用 QQ 登录</a> </li>
        <li class="sina"> <a href="http://sc.chinaz.com"> 使用 微博 登录</a> </li>
    </ul>
    <p>或者使用已有帐号登陆：</p>
    <?php $form = ActiveForm::begin([
        'id' => 'form-signup',
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'action' => Url::toRoute(['site/login']),
    ]); ?>
        <div class="form-arrow"></div>
        <?= $form->field($model,'username')->textInput(['placeholder'=>'用户名:'])->label(false)?>
        <?= $form->field($model,'password')->passwordInput(['placeholder'=>'密码:'])->label(false)?>
        <?= Html::submitButton('登录',['class'=>"btn btn-primary btn-block"])?>
        <div class="clearfix"></div>
        <?= $form->field($model, 'rememberMe')->checkbox() ?>
        <div style="color:#999;margin:1em 0">
            <?= Html::a(Yii::t('app','resetPwd'), ['site/request-password-reset']) ?>.
        </div>
        <ul class="third-parties">
            <li>
                <p data-url="">新浪微博帐号</p>
            </li>
            <li>
                <p data-url="">腾讯微博帐号</p>
            </li>
            <li>
                <p data-url="">豆瓣帐号</p>
            </li>
            <li>
                <p data-url=""></p>
            </li>
        </ul>
    <?php ActiveForm::end(); ?>
</div>
<div class="theme-popover-mask"></div>