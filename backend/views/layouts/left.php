<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/26
 * Time: 10:10
 */

use yii\helpers\Html;
use dmstr\widgets\Menu;
use yii\helpers\Url;

$isUser = ($this->context->module->id == 'user' || $this->context->module->id == 'admin')?true:false;
$isPost = ($this->context->module->id == 'post')?true:false;
?>
<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                    <?=Html::img('@web/img/20150511161039.jpg',['class'=>'img-circle'])?>
            </div>
            <div class="pull-left info">
                <?=Html::tag('p',Yii::t('app','Administrators'))?>
                <?=Html::a(
                    Html::tag('i','',['class'=>'fa fa-circle text-success']).Yii::t('app','on line'),
                    '#')
                ?>
            </div>
        </div>
        <!--TDO 搜索功能-->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <a class="btn btn-flat"><i class="fa fa-search"></i></a>
                </span>
            </div>
        </form>

<?= Menu::widget(
    [
        'options' => ['class' => 'sidebar-menu'],
        'items' => [
            ['label' => 'Yii2', 'options' => ['class' => 'header']],
            ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii']],
            ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug']],
            ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
            [
                'label' => '用户',
                'icon' => 'fa fa-share',
                'url' => '#',
                'options' => ['class'=>$isUser?'active':''],
                'items' => [
                    ['label' => Yii::t('app','user management'), 'icon' => 'fa fa-circle-o', 'url' => Url::to('/user'),],
                    ['label' => Yii::t('app','role management'), 'icon' => 'fa fa-circle-o', 'url' => Url::to('/admin/role'),],
                    ['label' => Yii::t('app','route management'), 'icon' => 'fa fa-circle-o', 'url' => Url::to('/admin/route'),],
                    ['label' => Yii::t('app','permission management'), 'icon' => 'fa fa-circle-o', 'url' => Url::to('/admin/permission'),],
                    //['label' => Yii::t('app','rule management'), 'icon' => 'fa fa-circle-o', 'url' => Url::to('/admin/rule'),],
                ],
            ],
            [
                'label' => '内容',
                'icon' => 'fa fa-share',
                'url' => '#',
                'options' => ['class'=>$isPost?'active':''],
                'items' => [
                    ['label' => '文章列表', 'icon' => 'fa fa-circle-o', 'url' => Url::to('/post'),],
                    ['label' => '发布文章', 'icon' => 'fa fa-circle-o', 'url' => Url::to('/post/default/create'),],
                    ['label' => '回收站', 'icon' => 'fa fa-circle-o', 'url' => Url::to('/post/default/recycle'),],
                    ['label' => '分类管理', 'icon' => 'fa fa-circle-o', 'url' => Url::to('/post/meta'),],
                    ['label' => '评论管理', 'icon' => 'fa fa-circle-o', 'url' => Url::to('/post/comment'),],
                    ['label' => '留言板', 'icon' => 'fa fa-circle-o', 'url' => ['/debug'],],
                    ['label' => '单页管理', 'icon' => 'fa fa-circle-o', 'url' => ['/debug'],],
                ],
            ],
            [
                'label' => '数据库',
                'icon' => 'fa fa-share',
                'url' => '#',
                'items' => [
                    ['label' => '备份', 'icon' => 'fa fa-circle-o', 'url' => ['/gii'],],
                    ['label' => '还原', 'icon' => 'fa fa-circle-o', 'url' => ['/debug'],],
                ],
            ],
            [
                'label' => '系统',
                'icon' => 'fa fa-share',
                'url' => '#',
                'items' => [
                    ['label' => '操作记录', 'icon' => 'fa fa-circle-o', 'url' => ['/gii'],],
                    ['label' => '配置', 'icon' => 'fa fa-circle-o', 'url' => ['/debug'],],
                    ['label' => '菜单管理', 'icon' => 'fa fa-circle-o', 'url' => ['/debug'],],
                ],
            ],
        ],
    ]
) ?>
    </section>
</aside>