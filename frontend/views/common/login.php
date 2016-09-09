<?php
use yii\helpers\Html;
use frontend\assets\AppAsset;
use yii\web\View;
/*View::registerJs("
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
", View::POS_END);*///在jq后面添加js代码
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
    <form class="login-form clearfix" method="post" action="http://sc.chinaz.com">
        <div class="form-arrow"></div>
        <input name="email" id='author' type="text" placeholder="名字：">
        <input name="password" type="password" placeholder="密码：">
        <input type="submit" name="type" class="button-blue login" value="登录">
        <input type="hidden" name="return-url" value="">
        <div class="clearfix"></div>
        <label class="remember">
            <input name="remember" type="checkbox" checked/>下次自动登录 </label>
        <a class="forgot">忘记密码？</a>
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
    </form>
</div>
<div class="theme-popover-mask"></div>
<script>
    $(document).ready(function(){
        $('.theme-popover-mask').fadeIn(100);
        $('#login-modal').slideDown(250);
    });
    $('#login-class').click(function(){
        $('.theme-popover-mask').fadeIn(100);
        $('#login-modal').slideDown(250);
    });
    $('#login-modal .close-login').click(function(){
        $('.theme-popover-mask').fadeOut(100);
        $('#login-modal').slideUp(200);
    });
</script>