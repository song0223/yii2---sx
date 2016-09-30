<?php
namespace common\widgets;

use Yii;

class MessagePrompt{
    const MSG_SUCCESS = 'success';
    const MSG_ERROR = 'error';
    const MSG_INFO = 'info';


    /**
     * 把消息提示整合一下，用起来方便一点
     */
    public static function setSucMsg($message){
        return self::setMessage(self::MSG_SUCCESS,$message);
    }

    public static function setErrorMsg($message){
        return self::setMessage(self::MSG_ERROR,$message);
    }

    public static function setInfoMsg($message){
        return self::setMessage(self::MSG_INFO,$message);
    }

    protected static function setMessage($type, $message){
        return Yii::$app->getSession()->setFlash($type,$message);
    }
}