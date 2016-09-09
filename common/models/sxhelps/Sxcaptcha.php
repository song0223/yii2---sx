<?php
namespace common\models\sxhelps;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/2
 * Time: 14:07
 */
class Sxcaptcha extends \yii\captcha\CaptchaValidator
{
    /**
     * @var boolean 是否忽略空
     */
    public $skipOnEmpty = false;

    /**
     * @var boolean 是否区分大小写
     */
    public $caseSensitive = false;

    /**
     * @var string 在控制器上配置的验证码action
     */
    public $captchaAction = '/site/captcha';
}