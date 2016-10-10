<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'language'=>'zh-CN',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@backend/message',
                    'fileMap' => [
                        'app' => 'app.php',
                    ],
                ],
                'power' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@backend/message',
                    'fileMap' => [
                        'power' => 'power.php',
                    ],
                ],
            ],
        ],
    ],
    'modules' => [
        'user' => [
            'class' => 'backend\modules\user\Module',
        ],
        'admin' => [
            'class' => 'backend\modules\rbac\Module',
            'layout' => '@backend/views/layouts/main',
        ],
        'post' => [
            'class' => 'backend\modules\post\Module',
        ],
    ],
    'as access' => [
        'class' => 'backend\modules\rbac\components\AccessControl',
        'allowActions' => [
            'site/*',//允许访问的节点，可自行添加
            'admin/*',//允许所有人访问admin节点及其子节点
            'gii/*',
            'debug/*'
        ]
    ],
    'params' => $params,
];
