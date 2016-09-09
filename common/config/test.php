<?php
return yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/main.php'),
    require(__DIR__ . '/main-local.php'),
    [
        'components' => [
            'db' => [
                'class' => 'yii\db\Connection',
                'dsn' => 'mysql:host=localhost;dbname=qrqy',
                'username' => 'root',
                'password' => '',
                'charset' => 'utf8mb4',
                'tablePrefix' => 'qrqy_'
            ]
        ]
    ]
);