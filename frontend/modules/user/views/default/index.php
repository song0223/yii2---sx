<?php
/* @var $this yii\web\View */

use yii\widgets\ListView;
use yii\helpers\Html;
use yii\widgets\Menu;
use common\models\User;
use common\models\sxhelps\SxHelps;

$username = Yii::$app->request->get('username');
$this->title = $username;
?>
<div class="row">
    <section class="container user-default-index">
        <div class="col-sm-3">
            <!--left col-->
            <div class="panel panel-default thumbnail center">
                <div class="panel-body">
                    <div class="media">
                        <div class="media-left media-middle">
                            <?= Html::img('',['class' => 'media-object', 'alt' =>''])?>
                        </div>
                        <div class="media-body">
                            <?= Html::tag('h2',Html::tag('strong',$username),['class' =>'mt5'])?>
                            <p>第 <?= $model->id?> 位会员</p>
                            <div class="pull-left">
                                <span class="label label-success role"><?= User::role_map($model->role)?></span>
                            </div>
                        </div>
                    </div>

                    <div class="follow-info row">
                        <div class="col-sm-4 followers" data-login="rei">
                            <?= Html::a(42,'#',['class' => 'counter'])?>
                            <?= Html::a('积分','#',['class' => 'text'])?>
                        </div>
                        <div class="col-sm-4 following">
                            <?= Html::a($model->userInfo['like_count'],'#',['class' => 'counter'])?>
                            <?= Html::a('赞','#',['class' => 'text'])?>
                        </div>
                        <div class="col-sm-4 stars">
                            <?= Html::a($model->userInfo['thanks_count'],'#',['class' => 'counter'])?>
                            <?= Html::a('感谢','#',['class' => 'text'])?>
                        </div>
                    </div>
                    <!-- <button type="button" class="btn btn-success">Book me!</button> -->
                    <!-- <button type="button" class="btn btn-info">Send me a message</button> -->
                    <!-- <br> -->
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-user"></i>个人信息</div>
                <ul class="list-group">
                    <li class="list-group-item text-right">
                        <?= Html::tag('span',Html::tag('strong','加入于'),['class' =>'pull-left'])?>
                        <?= date('Y-m-d H:i:s',$model->created_at)?>
                    </li>
                    <li class="list-group-item text-right">
                        <?= Html::tag('span',Html::tag('strong','最后登录时间'),['class' =>'pull-left'])?>
                        <?= SxHelps::get_timejq($model->userInfo['prev_login_time']) ?>
                    </li>
                </ul>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-dashboard"></i>个人成就</div>
                <ul class="list-group">
                    <li class="list-group-item text-right">
                        <?= Html::tag('span',Html::tag('strong','发表文章次数'),['class' =>'pull-left'])?>
                        <?= $model->userInfo['post_count']?>
                    </li>
                    <li class="list-group-item text-right">
                        <?= Html::tag('span',Html::tag('strong','发布评论次数'),['class' =>'pull-left'])?>
                        <?= $model->userInfo['comment_count']?>
                    </li>
                    <li class="list-group-item text-right">
                        <?= Html::tag('span',Html::tag('strong','个人主页浏览次数'),['class' =>'pull-left'])?>
                        <?= $model->userInfo['view_count']?>
                    </li>
                </ul>
            </div>
            <!-- <div class="panel panel-default">
                <div class="panel-heading">社交网络</div>
                <div class="panel-body">
                    <i class="fa fa-facebook fa-2x"></i>
                    <i class="fa fa-github fa-2x"></i>
                    <i class="fa fa-twitter fa-2x"></i>
                    <i class="fa fa-pinterest fa-2x"></i>
                    <i class="fa fa-google-plus fa-2x"></i>
                </div>
            </div> -->
        </div>
        <!--/col-3-->
        <div class="col-sm-9 list-nav mb20" contenteditable="false" style="">
            <nav class="navbar navbar-default">
                <ul class="nav navbar-nav">
                    <?= Menu::widget([
                        'options' => [
                            'class' => 'nav navbar-nav',
                        ],
                        'items' => [
                            ['label' => '最新评论',  'url' => ['/user/default/index', 'username'=> $username]],
                            ['label' => '最新主题',  'url' => ['/user/default/post', 'username'=> $username]],
                            ['label' => '最新收藏',  'url' => ['/user/default/favorite', 'username'=> $username]],
                            //['label' => '积分动态',  'url' => ['/user/default/point', 'username'=> $username]],
                        ]
                    ])?>
                </ul>
            </nav>

            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'list-group-item'],
                'summary' => false,
                'itemView' => '_item',
                'options' => ['class' => 'list-group'],
            ])?>
        </div>
    </section>
</div>
