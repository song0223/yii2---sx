<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/28
 * Time: 15:49
 */

use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="col-md-3 side-bar p0">
    <div class="panel panel-default corner-radius">
        <div class="panel-heading text-center">
            <h3 class="panel-title">瞎扯淡</h3>
        </div>
        <div class="panel-body text-center">
            <?=Html::a('发布新帖',Url::to('/post/default/create'),['class'=>'btn btn-success'])?>
        </div>
    </div>

    <div class="panel panel-default corner-radius">
        <div class="panel-heading text-center">
            <h3 class="panel-title">小贴士</h3>
        </div>
        <div class="panel-body">
            <p>珍惜生命，远离百度搜索。<a href="/topic/default/view/15">我有一万种方法上谷歌</a>。</p>
        </div>
    </div>

    <div class="panel panel-default corner-radius">
        <div class="panel-heading text-center">
            <h3 class="panel-title">友情链接</h3>
        </div>
        <div class="panel-body text-center" style="padding-top: 5px;">
            <a class="list-group-item" href="http://www.yiichina.com/" title="yiichina" target="_blank">
                <img src="http://www.yiichina.com/images/logo.png" alt="">
            </a>
        </div>
    </div>

    <div class="panel panel-default corner-radius">
        <div class="panel-heading text-center">
            <h3 class="panel-title">推荐资源</h3>
        </div>
        <div class="panel-body side-bar">
            <ul class="list">
                <li><a href="http://www.digpage.com/">深入理解Yii2.0</a></li><li><a href="http://www.phpcomposer.com/">Composer 中文文档</a></li><li><a href="https://github.com/PizzaLiu/PHP-FIG">PHP-FIG 编程规范中文</a></li><li><a href="http://laravel-china.github.io/php-the-right-way/">PHP The Right Way 中文版</a></li><li><a href="https://github.com/forecho/awesome-yii2">awesome-yii2（Yii2 干货）</a></li><li><a href="http://phptrends.com/">上升最快的 PHP 类库</a></li><li><a href="http://www.book.php.code.kekou.de/">Hacking with PHP</a></li><li><a href="http://pkg.phpcomposer.com/">Packagist / Composer 中国全量镜像</a></li><li><a href="http://cookbook.getyii.com/"> Yii 2.0 Cookbook 中国翻译版</a></li>            </ul>
        </div>
    </div>
</div>
