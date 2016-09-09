<?php
/*
 * 页面公共部分 单独写出来
 *
 */
namespace frontend\widgets;

use yii\bootstrap\Widget;

class Nav extends Widget
{
        public function run(){
            return $this->render('nav');
        }
}