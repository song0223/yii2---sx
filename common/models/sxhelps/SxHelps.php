<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/22
 * Time: 15:09
 */

namespace common\models\sxhelps;


class SxHelps
{
    /*
        * @param string 需要截取的字符串
        * @param int 长度
        * @param string ... 省略代替
        * @return string ...
        */
    public static function truncate_utf8_string($string, $length, $etc = '...')
    {
        $result = '';
       // $string = html_entity_decode(trim(strip_tags($string)), ENT_QUOTES, 'UTF-8');
        $strlen = strlen($string);
        for ($i = 0; (($i < $strlen) && ($length > 0)); $i++)
        {
            if ($number = strpos(str_pad(decbin(ord(substr($string, $i, 1))), 8, '0', STR_PAD_LEFT), '0'))
            {
                if ($length < 1.0)
                {
                    break;
                }
                $result .= substr($string, $i, $number);
                $length -= 1.0;
                $i += $number - 1;
            }
            else
            {
                $result .= substr($string, $i, 1);
                $length -= 0.5;
            }
        }
        //$result = htmlspecialchars($result, ENT_QUOTES, 'UTF-8');
        if ($i < $strlen)
        {
            $result .= $etc;
        }
        return $result;
    }


    /*
     *  获取字段名称
     */
    public static function getItems($items, $key=null){
        if($key){
            if(array_key_exists($key,$items)){
                return $items[$key];
            }
        }else{
            return $items;
        }
    }


    /*
     *  去掉空格 换行等
     * @param string
     *
     */
    public static function conversion($keyword){
        $keyword = html_entity_decode($keyword);
        $keyword = str_replace(array("\r\n","\r","\n"),'',strip_tags($keyword));
        return $keyword;
    }


    /*
     *  获取两个时间中有多少天 多少个小时。。
     * @param string $begin_time 开始时间
     * @param string $end_time 结束时间
     * @return array
     */
    public static function timediff( $begin_time, $end_time )
    {
        if ( $begin_time < $end_time ) {
            $starttime = $begin_time;
            $endtime = $end_time;
        } else {
            $starttime = $end_time;
            $endtime = $begin_time;
        }
        $timediff = $endtime - $starttime;
        $days = intval( $timediff / 86400 );
        $remain = $timediff % 86400;
        $hours = intval( $remain / 3600 );
        $remain = $remain % 3600;
        $mins = intval( $remain / 60 );
        $secs = $remain % 60;
        $res = array( "day" => $days, "hour" => $hours, "min" => $mins, "sec" => $secs );
        return $res;
    }

    /*
     * @param $time 时间戳
     * @return string 最后得出 xx秒前
     */
    public static function get_timejq($time){
        //计算天数
        $timediff = time()-$time;
        $days = intval($timediff/86400);
        if($days!=0){
            return $days."天前";
        }
        //计算小时数
        $remain = $timediff%86400;
        $hours = intval($remain/3600);
        if($hours!=0){
            return $hours."小时前";
        }
        //计算分钟数
        $remain = $remain%3600;
        $mins = intval($remain/60);
        if($mins!=0){
            return $mins."分钟前";
        }
        //计算秒数
        $secs = $remain%60;

        return $secs."秒前";

    }

    /*
     * @param Json
     * @return
     */
    public static function format_ErrorJson($json){
        $newJson = str_replace('{','',$json);
        $newJson = str_replace('}','',$newJson);
        $newJson = explode(',',$newJson);
        foreach($newJson as $k=>$v){
            if (preg_match('/http:\/\/[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is',$v)){
                $con = explode(':',$v);
                $newJson1[trim($con[0])] = trim($con[1]).':'.trim($con[2]);
            }else{
                $con = explode(':',$v);
                $newJson1[trim($con[0])] = trim($con[1]);
            }
        }
        return $newJson1;
    }


    /**
     * 判断访问是否为手机
     */
    public static function isMobile()
    {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER ['HTTP_X_WAP_PROFILE'])) {
            return true;
        }
        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset ($_SERVER ['HTTP_VIA'])) {
            // 找不到为flase,否则为true
            return stristr($_SERVER ['HTTP_VIA'], "wap") ? true : false;
        }
        // 脑残法，判断手机发送的客户端标志,兼容性有待提高
        if (isset ($_SERVER ['HTTP_USER_AGENT'])) {
            $clientkeywords = array(
                'nokia',
                'sony',
                'ericsson',
                'mot',
                'samsung',
                'htc',
                'sgh',
                'lg',
                'sharp',
                'sie-',
                'philips',
                'panasonic',
                'alcatel',
                'lenovo',
                'iphone',
                'ipod',
                'blackberry',
                'meizu',
                'android',
                'netfront',
                'symbian',
                'ucweb',
                'windowsce',
                'palm',
                'operamini',
                'operamobi',
                'openwave',
                'nexusone',
                'cldc',
                'midp',
                'wap',
                'mobile'
            );
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER ['HTTP_USER_AGENT']))) {
                return true;
            }
        }
        // 协议法，因为有可能不准确，放到最后判断
        if (isset ($_SERVER ['HTTP_ACCEPT'])) {
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER ['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER ['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER ['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER ['HTTP_ACCEPT'], 'text/html')))) {
                return true;
            }
        }
        return false;
    }

    public static function getVideoCover($file,$time,$name){
        if(empty($time))$time = '1';//默认截取第一秒第一帧
        $strlen = strlen($file);
        // $videoCover = substr($file,0,$strlen-4);
        // $videoCoverName = $videoCover.'.jpg';//缩略图命名
        //exec("ffmpeg -i ".$file." -y -f mjpeg -ss ".$time." -t 0.001 -s 320x240 ".$name."",$out,$status);
        $str = "ffmpeg -i ".$file." -y -f mjpeg -ss 3 -t ".$time." -s 320x240 ".$name;
        //echo $str."</br>";
        $result = system($str);
        return $result;
    }

}


