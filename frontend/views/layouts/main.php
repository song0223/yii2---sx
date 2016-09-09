<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use frontend\assets\BowerAsset;

AppAsset::register($this);
BowerAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?= frontend\widgets\Nav::widget();?>
    <div class="container">
        <?= Breadcrumbs::widget([//标签 用户/用户管理
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>
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
<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>
<!--小人只在首页显示 start*-->

<div id="spig" class="spig">
    <div id="message">正在加载中……</div>
    <div id="mumu" class="mumu"></div>
</div>
<div class="theme-popover-mask"></div>
<!--小人end*-->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
<script type="text/javascript">
    var isindex = true;
    var visitor = true;
        $('#login-class').click(function(){
            $('.theme-popover-mask').fadeIn(100);
            $('#login-modal').slideDown(250);
        });
        $('#login-modal .close-login').click(function(){
            $('.theme-popover-mask').fadeOut(100);
            $('#login-modal').slideUp(200);
        });

</script>