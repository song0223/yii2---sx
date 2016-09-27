<?php
/**
 * Created by PhpStorm.
 * User: sxxxx
 * Date: 2016/9/8
 * Time: 10:08
 */

namespace backend\assets;


use yii\web\AssetBundle;

class BowerAsset extends AssetBundle
{
    public $sourcePath = '@bower';
    public $baseUrl = '@bower';

    public $css = [
        'pace/themes/green/pace-theme-minimal.css',
    ];

    public $js = [
        'pace/pace.min.js',
    ];
}