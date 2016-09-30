<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\User;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
$isCreate = ($this->context->action->id == 'create')?true:false;
$isUpdate = ($this->context->action->id == 'update')?true:false;
$isAssign = ($this->context->action->id == 'assign-ment')?true:false;
?>

    <div class="col-md-3">
        <div class="box box-solid">
            <div class="box-body no-padding">
                <ul id="w1" class="nav nav-pills nav-stacked">
                    <li class=<?=$isCreate?'active':''?><?=$isUpdate?'active':''?>><a href="<?=Url::to(['/user/default/update','id'=>$model->id])?>"><i class="fa fa-file-text-o"></i> 信息</a></li>
                    <li class=<?=$isCreate?'disabled':''?>><a href="#"><i class="fa fa-user"></i> 账户</a></li>
                    <li class=<?=$isCreate?'disabled':''?> <?=$isAssign?'active':''?>><a href="<?=Url::to(['/user/default/assign-ment','id'=>$model->id])?>"><span class="glyphicon glyphicon-hand-left"></span> 指派</a></li>
                </ul>
            </div>
        </div>
        <?php if(!$isCreate):?>
        <div class="box box-solid">
            <div class="box-body no-padding">
                <ul id="w1" class="nav nav-pills nav-stacked">
                    <?php if($model->status == User::STATUS_DELETED):?>
                        <li>
                            <?= Html::a(
                                Html::tag('i','',['class'=>'fa fa-ban']).
                                Yii::t('app', 'Lift a ban'), ['lift-ban', 'id' => $model->id], [
                                'data' => [
                                    'confirm' => Yii::t('app', 'Are you sure you want to Lift a ban this item?'),
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </li>
                    <?php else: ?>
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
                    <?php endif;?>
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
