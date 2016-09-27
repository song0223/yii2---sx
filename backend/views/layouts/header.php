<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
?>
<header class="main-header">
    <?=Html::a(
        Html::tag('span',Yii::t('app','Identification'),['class'=>'logo-mini']).
        Html::tag('span',Yii::t('app','Handsome up'),['class'=>'logo-lg']),
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
                        Html::img('@web/img/20150511161039.jpg',['class'=>'user-image']).
                        Html::tag('span',Yii::t('app','Administrators'),['class'=>'hidden-xs']),
                        '#',
                        ['class'=>'dropdown-toggle','data-toggle'=>'dropdown'])
                    ?>
                    <ul class="dropdown-menu pull-right" style="width: auto">
                        <li>
                            <?=Html::a(
                                Html::tag('i','',['class'=>'fa fa-user']).Yii::t('app','Personal information'),
                                '#',
                                ['class'=>'menuItem','data-id'=>'userInfo'])
                            ?>
                        </li>
                        <li>
                            <?=Html::a(
                                Html::tag('i','',['class'=>'fa fa-trash-o']).Yii::t('app','wipe cache'), '#')
                            ?>
                        </li>
                        <li>
                            <?=Html::a(
                                Html::tag('i','',['class'=>'fa fa-paint-brush']).Yii::t('app','Skin setting'), '#')
                            ?>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <?=Html::a(
                                Html::tag('i','',['class'=>'ace-icon fa fa-power-off']).Yii::t('app','Safe exit'), Url::to(['site/logout'])
                                )
                            ?>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>