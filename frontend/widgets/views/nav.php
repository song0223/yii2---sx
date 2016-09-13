<?php
/**
 * Created by PhpStorm.
 * User: sxxxx
 * Date: 2016/9/7
 * Time: 13:55
 */
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
use yii\web\Controller;

$controller = Yii::$app->controller->id;
$action = Yii::$app->controller->action->id;
$hotActive = ($controller == 'hot') ? true : false;
$videoActive = ($controller == 'video') ? true : false;
$textActive = ($controller == 'text') ? true : false;
$historyActive = ($controller == 'history') ? true : false;
$picActive = ($controller == 'pic') ? true : false;
$textnewActive = ($controller == 'textnew') ? true : false;
$contributeActive = ($controller == 'contribute') ? true : false;
    NavBar::begin([
        'brandLabel' => Yii::t('app','WebTitle'),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-default',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'nav navbar-nav'],
        'items' => [
            ['label' => Yii::t('app','mainHot'), 'url' => ['/hot/hot'],'active' => $hotActive],
            ['label' => Yii::t('app','mainVideo'),'url' => ['/video/about'],'active' => $videoActive],
            ['label' => Yii::t('app','mainText'),'url' => ['/text/about'],'active' => $textActive],
            ['label' => Yii::t('app','mainHistory'),'url' => ['/history/about'],'active' => $historyActive],
            ['label' => Yii::t('app','mainPic'),'url' => ['/pic/about'],'active' => $picActive],
            ['label' => Yii::t('app','mainTextnew'),'url' => ['/textnew/about'],'active' => $textnewActive],
            ['label' => Yii::t('app','mainContribute'),'url' => ['/contribute/about'],'active' => $contributeActive],
        ],
    ]);
    echo '<form class="navbar-form navbar-left" role="search" action="/search" method="get">
                <div class="form-group">
                    <input type="text" value="" name="keyword" class="form-control search_input" id="navbar-search" placeholder="'.Yii::t('app','mainPlaceholder').'" data-placement="bottom" data-content="'.Yii::t('app','mainDataContent').'">
                </div>
            </form>';
//    $menuItems = [
//        ['label' => Yii::t('app','Home'), 'url' => ['/site/index']],
//        ['label' => Yii::t('app','About'), 'url' => ['/site/about']],
//        ['label' => Yii::t('app','Contact'), 'url' => ['/site/contact']],
//    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => Yii::t('app','Login'), 'url' => '#', 'linkOptions' =>['id'=>'login-class']];
        $menuItems[] = ['label' => Yii::t('app','Signup'), 'url'=>'#', 'linkOptions' =>['id'=>'signup-class']];
        echo Yii::$app->runAction('site/login-view');
    } else {
//        $menuItems[] = '<li>'
//            . Html::beginForm(['/site/logout'], 'post')
//            . Html::submitButton(
//                'Logout (' . Yii::$app->user->identity->username . ')',
//                ['class' => 'btn btn-link']
//            )
//            . Html::endForm()
//            . '</li>';
        $menuItems[] = [
            'label' => Yii::$app->user->identity->username,
            'items'=>[
                ['label' => Yii::t('app','memberInfo'), 'url' => ['/user/about']],
                ['label' => Yii::t('app','settingProfile'), 'url' => ['/user/about']],
                ['label' => Yii::t('app','memberLogout'), 'url' => ['/site/logout'],'linkOptions' => ['data-method' => 'post']],
            ]
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
