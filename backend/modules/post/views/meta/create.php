<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PostMeta */

$this->title = Yii::t('app', 'Create Post Meta');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Post Metas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-meta-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
