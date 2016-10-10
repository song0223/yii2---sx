<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\AutoDelayAlert;
use backend\assets\BowerAsset;
use dmstr\web\AdminLteAsset;
use yii\helpers\Inflector;

AppAsset::register($this);
BowerAsset::register($this);
AdminLteAsset::register($this);
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
<body class="skin-blue sidebar-mini fixed  pace-done">
<?php $this->beginBody() ?>
<!--div id="ajax-loader1" class="ajaxLoad1">
    <//?=Html::img('@web/img/ajax-loader.gif',['class'=>'loaderImg'])?>
</div-->
<div class="wrapper" style="background: transparent">
    <!--头部信息-->
    <?=$this->render('header'); ?>
    <!--左边导航-->
    <?=$this->render('left');?>
    <div class="content-wrapper">
        <section class="content-header">
            <?php if (isset($this->blocks['content-header'])) { ?>
                <h1><?= $this->blocks['content-header'] ?></h1>
            <?php } else { ?>
                <h1>
                    <?php
                    if ($this->title !== null) {
                        echo Html::encode($this->title);
                    } else {
                        echo Inflector::camel2words(
                            Inflector::id2camel($this->context->module->id)
                        );
                        echo ($this->context->module->id !== \Yii::$app->id) ? '<small>Module</small>' : '';
                    } ?>
                </h1>
            <?php } ?>
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
        </section>
        <section class="content">
            <?= AutoDelayAlert::widget(['delay'=>3000]) ?>
            <?= $content ?>
        </section>
    </div>
</div>

<footer class="main-footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
