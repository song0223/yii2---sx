<?php
namespace backend\widgets\grid;

use Yii;
use yii\helpers\Html;
use yii\grid\ActionColumn;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/27
 * Time: 10:15
 */
class ActionWidget extends ActionColumn
{
    public $template = '{view} {update} {delete}';
    public $header = '操作';

    /**
     * Initializes the default button rendering callbacks.
     */
    protected function initDefaultButtons()
    {
        if (!isset($this->buttons['view'])) {
            $this->buttons['view'] = function ($url, $model, $key) {
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                    'title' => Yii::t('app','Look'),
                    'data-method' => 'user',
                    'data-pjax' => '0',
                    'class' => 'btn btn-default btn-xs'
                ]);
            };
        }
        if (!isset($this->buttons['update'])) {
            $this->buttons['update'] = function ($url, $model, $key) {
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                    'title' => Yii::t('app','Update User'),
                    'data-method' => 'user',
                    'data-pjax' => '0',
                    'class' => 'btn btn-default btn-xs'
                ]);
            };
        }
        if (!isset($this->buttons['delete'])) {
            $this->buttons['delete'] = function ($url, $model, $key) {
                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                    'title' => Yii::t('app','Delete'),
                    'data-method' => 'user',
                    'data-pjax' => '0',
                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                    'class' => 'btn btn-default btn-xs'
                ]);
            };
        }
    }
}