<?php

/* @var $this yii\web\View */

use yii\widgets\ListView;

$this->title = Yii::t('app','WebTitle');
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <?php if(!$tag):?>
    <div class="panel panel-default">
        <div class="panel-body text-center mp0">
            多学一点知识，就少写一行代码。
        </div>
    </div>
    <?php endif;?>
    <div class="col-md-9 topic">
        <?php if($tag):?>
            <div class="panel panel-default">
        <?php else:?>
            <div class="">
        <?php endif;?>
        <?php if($tag):?>
            <div class="panel-heading clearfix">
                <div class="pull-left">搜索标签：<?=$tag['tag'];?></div>
            </div>
            <?php endif;?>
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'panel panel-default'],
                'summary' => false,
                'itemView' => $tag? '_tagItem': '_item',
                'options' => $tag?['class' => 'list-group']:'',
            ]) ?>
        </div>
    </div>
        <?=$this->render('@frontend/views/common/right_panel')?>
</div>