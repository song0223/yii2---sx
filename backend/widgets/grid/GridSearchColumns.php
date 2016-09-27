<?php
namespace backend\widgets\grid;
use kartik\daterange\DateRangePicker;

use yii\helpers\Html;

class GridSearchColumns{

        /**
         * 下拉搜索框
         * @param string $fieldNmae 字段名称 格式 searchModel[role]
         * @param array $searchData 字段数据 key
         * @param array $mapData 字段数据对应名称 value
         * @return string
         */
        public static function makeDropDownList($fieldNmae, $searchData, $mapData = null){
            return Html::dropDownList($fieldNmae, $searchData, $mapData, ['class' => 'form-control', 'style' => ['min-width' => '100px'],'prompt' => '全部']);
        }


        /**
         * 时间区间搜索
         * @param string $fieldNmae
         * @param object $searchModel
         * @return string
         */
        public static function makeDatePicker($fieldNmae, $searchModel){
            return DateRangePicker::widget([
                'model'=>$searchModel,
                'attribute'=>$fieldNmae,
                'convertFormat'=>true,
                'readonly' => true,
                'pluginOptions'=>[
                    'separator' => ' _ ',
                    'locale'=>['format' => 'Y/m/d H:i'],
                    'timePicker' => true,
                    'timePicker12Hour' => true,
                    'timePickerIncrement' => 1,
                    'opens' => 'left'
                ]
            ]);
        }
}