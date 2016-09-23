<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
?>
<header class="main-header">
    <?=Html::a(
        Html::tag('span','大神',['class'=>'logo-mini']).
        Html::tag('span','每天都被自己帅醒！',['class'=>'logo-lg']),
        'index',
        ['class'=>'logo'])
    ?>
    <nav class="navbar navbar-static-top">
        <a class="sidebar-toggle">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown messages-menu">
                    <?= Html::a(
                        Html::tag('i','',['class'=>'fa fa-envelope-o']).
                        Html::tag('span',4,['class'=>'label label-success']),
                        '#',
                        ['class'=>'dropdown-toggle','data-toggle'=>'dropdown'])
                    ?>
                </li>
                <li class="dropdown notifications-menu">
                    <?= Html::a(
                        Html::tag('i','',['class'=>'fa fa-bell-o']).
                        Html::tag('span',4,['class'=>'label label-warning']),
                        '#',
                        ['class'=>'dropdown-toggle','data-toggle'=>'dropdown'])
                    ?>
                </li>
                <li class="dropdown tasks-menu">
                    <?= Html::a(
                        Html::tag('i','',['class'=>'fa fa-flag-o']).
                        Html::tag('span',4,['class'=>'label label-danger']),
                        '#',
                        ['class'=>'dropdown-toggle','data-toggle'=>'dropdown'])
                    ?>
                </li>
                <li class="dropdown user user-menu">
                    <?= Html::a(
                        Html::img('@web/img/user2-160x160.jpg',['class'=>'user-image']).
                        Html::tag('span','管理员',['class'=>'hidden-xs']),
                        '#',
                        ['class'=>'dropdown-toggle','data-toggle'=>'dropdown'])
                    ?>
                    <ul class="dropdown-menu pull-right">
                        <li>
                            <?=Html::a(
                                Html::tag('i','',['class'=>'fa fa-user']).'个人信息',
                                '#',
                                ['class'=>'menuItem','data-id'=>'userInfo'])
                            ?>
                        </li>
                        <li>
                            <?=Html::a(
                                Html::tag('i','',['class'=>'fa fa-trash-o']).'清空缓存', '#')
                            ?>
                        </li>
                        <li>
                            <?=Html::a(
                                Html::tag('i','',['class'=>'fa fa-paint-brush']).'皮肤设置', '#')
                            ?>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <?=Html::a(
                                Html::tag('i','',['class'=>'ace-icon fa fa-power-off']).'安全退出', Url::to(['site/logout'])
                                )
                            ?>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>