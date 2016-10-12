<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/12
 * Time: 15:09
 */

namespace common\widgets;


use kartik\select2\Select2;
use yii\helpers\Url;
use yii\web\JsExpression;

class SelectInput extends Select2
{
        public $toggleAllSettings = [
            'selectLabel' => '<i class="glyphicon glyphicon-ok-circle"></i> 选择全部',
            'unselectLabel' => '<i class="glyphicon glyphicon-remove-circle"></i> 删除全部',
            'selectOptions' => ['class' => 'text-success'],
            'unselectOptions' => ['class' => 'text-danger'],
        ];

        public $options = ['placeholder' => '标签(可选)', 'multiple' => true];

        public $ajaxUrl = ['/post/default/tags'];

        public $pluginOptions = [
            'tags' => true,
            'maximumInputLength' => 10,
        ];

        public function init()
        {
            parent::init();
            $this->pluginOptions['ajax'] = [
                'url' => Url::to($this->ajaxUrl),
                'dataType' => 'json',
                'data' => new JsExpression("function(params) { return {q:params.term,meta:$('#topic-post_meta_id option:selected').val()}; }")
            ];
        }
}