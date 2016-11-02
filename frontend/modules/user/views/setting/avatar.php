<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/2
 * Time: 16:06
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form ActiveForm */
$this->title = '头像设置';
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
                <?= \hyii2\avatar\AvatarWidget::widget(['imageUrl'=>$model->avatar]); ?>
            </div>
        </div>
    </div>

</section>
