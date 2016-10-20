<?php

?>
<div class="panel panel-default">
    <div class="panel-heading clearfix">
        添加评论 <?php if (Yii::$app->user->getIsGuest()): ?> <small class="text-warning">(需要登录)</small> <?php endif ?>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
