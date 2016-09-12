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
//AppAsset::addScript($this,Yii::$app->request->baseUrl."/js/loginAjax.js");//在jq后面添加js文件
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
<!--小人end*-->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
<script type="text/javascript">
    var isindex = true;
    var visitor = true;
</script>