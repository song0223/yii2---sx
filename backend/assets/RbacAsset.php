<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class RbacAsset extends AssetBundle
{
    /**
     * {@inheritdoc}
     */
    public $sourcePath = '@web';
    /**
     * {@inheritdoc}
     */
    public $js = [
        'yii.admin.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
