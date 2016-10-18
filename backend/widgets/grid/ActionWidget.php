<?php
namespace backend\widgets\grid;

use Yii;
use yii\helpers\Html;
use yii\grid\ActionColumn;
use yii\helpers\Url;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/27
 * Time: 10:15
 */
class ActionWidget extends ActionColumn
{
    public $template = '{:view} {:update} {:delete}';
    public $header = '操作';
    /**
     * Initializes the default button rendering callbacks.
     */
    protected function initDefaultButtons()
    {
        if (!isset($this->buttons['create'])) {
            $this->buttons['create'] = function ($url, $model, $key) {
                return Html::a('<span class="glyphicon glyphicon-plus"></span>', $url, [
                    'title' => Yii::t('app','create'),
                    'class' => 'btn btn-default btn-xs'
                ]);
            };
        }
        if (!isset($this->buttons['view'])) {
            $this->buttons['view'] = function ($url, $model, $key) {
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                    'title' => Yii::t('app','Look'),
                    'class' => 'btn btn-default btn-xs'
                ]);
            };
        }
        if (!isset($this->buttons['update'])) {
            $this->buttons['update'] = function ($url, $model, $key) {
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                    'title' => Yii::t('app','Update User'),
                    'class' => 'btn btn-default btn-xs'
                ]);
            };
        }
        if (!isset($this->buttons['delete'])) {
            $this->buttons['delete'] = function ($url, $model, $key) {
                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                    'title' => Yii::t('app','Delete'),
                    'data-method' => 'post',
                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                    'class' => 'btn btn-default btn-xs'
                ]);
            };
        }
    }

    /**
     * 重写了标签渲染方法。
     * @param mixed $model
     * @param mixed $key
     * @param int $index
     * @return mixed
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        return preg_replace_callback('/\\{([^}]+)\\}/', function ($matches) use ($model, $key, $index) {
            list($name, $type) = explode(':', $matches[1].':'); // 得到按钮名和类型
            if (!isset($this->buttons[$type])) { // 如果类型不存在 默认为view
                $type = 'view';
            }
            if ('' == $name) { // 名称为空，就用类型为名称
                $name = $type;
            }
            $url = $this->createUrl($name, $model, $key, $index);
            return call_user_func($this->buttons[$type], $url, $model, $key);
        }, $this->template);
    }

    /**
     * 生成Url功能 可以指定参数名称
     * @param string $action
     * @param \yii\db\ActiveRecord $model
     * @param mixed $key
     * @param int $index
     * @return mixed|string

    public function createUrl($action, $model, $key, $index)
    {
        if (is_callable($this->urlCreator)) {
            return call_user_func($this->urlCreator, $action, $model, $key, $index, $this);
        } else {
            $params = is_array($key) ? $key : [$this->urlPar => (string) $key];
            $params[0] = $this->controller ? $this->controller . '/' . $action : $action;

            return Url::toRoute($params);
        }
    }*/
}