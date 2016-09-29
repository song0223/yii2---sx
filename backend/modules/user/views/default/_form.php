<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
$isCreate = ($this->context->action->id == 'create')?true:false;
$isAssign = ($this->context->action->id == 'assign-ment')?true:false;
?>

    <div class="col-md-3">
        <div class="box box-solid">
            <div class="box-body no-padding">
                <ul id="w1" class="nav nav-pills nav-stacked">
                    <li class=<?=$isCreate?'active':''?>><a href="#"><i class="fa fa-file-text-o"></i> 信息</a></li>
                    <li class=<?=$isCreate?'disabled':''?>><a href="#"><i class="fa fa-user"></i> 账户</a></li>
                    <li class=<?=$isCreate?'disabled':''?> <?=$isAssign?'active':''?>><a href="<?=\yii\helpers\Url::to(['/user/default/assign-ment','id'=>$model->id])?>"><span class="glyphicon glyphicon-hand-left"></span> 指派</a></li>
                </ul>
            </div>
        </div>
        <?php if(!$isCreate):?>
        <div class="box box-solid">
            <div class="box-body no-padding">
                <ul id="w1" class="nav nav-pills nav-stacked">
                    <li>
                        <?= Html::a(
                            Html::tag('i','',['class'=>'fa fa-ban']).
                            Yii::t('app', 'Ban'), ['ban', 'id' => $model->id], [
                            'data' => [
                                'confirm' => Yii::t('app', 'Are you sure you want to ban this item?'),
                                'method' => 'post',
                            ],
                        ]) ?>
                    </li>
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
