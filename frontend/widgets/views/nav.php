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
use common\models\PostMeta;
use yii\helpers\Url;

$controller = Yii::$app->controller->id;
$action = Yii::$app->controller->action->id;
//$hotActive = ($controller == 'hot') ? true : false;
$mid = Yii::$app->request->getQueryParam('meta_id');
    NavBar::begin([
        'brandLabel' => Yii::t('app','WebTitle'),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-default',
        ],
    ]);
    $tree = [];
    foreach(PostMeta::getClassifying(1) as $k=>$v){
        $tree[$k] = [
            'label' => $v,
            'url' => Url::to(['/post/default/index','meta_id'=>$k]),
            'active' => ($mid == $k) ? true :false
        ];
    }

    echo Nav::widget([
        'options' => ['class' => 'nav navbar-nav'],
        'items' => $tree,
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
        $menuItems[] = ['label' => Yii::t('app','Login'), 'url' => ['/site/login'], 'linkOptions' =>['id'=>'login-class']];
        $menuItems[] = ['label' => Yii::t('app','Signup'), 'url'=>['/site/signup'], 'linkOptions' =>['id'=>'signup-class']];
        //echo Yii::$app->runAction('site/login-view');
    } else {
//        $menuItems[] = '<li>'
//            . Html::beginForm(['/site/logout'], 'post')
//            . Html::submitButton(
//                'Logout (' . Yii::$app->user->identity->username . ')',
//                ['class' => 'btn btn-link']
//            )
//            . Html::endForm()
//            . '</li>';
        $username = Yii::$app->user->identity->username;
        $menuItems[] = [
            'label' => $username,
            'items'=>[
                ['label' => Yii::t('app','memberInfo'), 'url' => Url::to(['/user/default/index','username'=>$username])],
                ['label' => Yii::t('app','settingProfile'), 'url' => Url::to(['/user/default/index','username'=>$username])],
                ['label' => Yii::t('app','memberLogout'), 'url' => ['/site/logout'],'linkOptions' => ['data-method' => 'post']],
            ]
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
