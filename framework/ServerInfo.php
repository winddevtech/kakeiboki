<?php
/*
 * SERVER変数クラス
 */
class ServerInfo {
    public static function getReqMethod($method_name){
        if (self::getServerInfo('REQUEST_METHOD') == $method_name){
            return true;
        }
        return false;
    }
    
    public static function getReferer($pate_url){
        if (self::getServerInfo('HTTP_REFERER') == $pate_url){
            return true;
        }
        return false;
    }
    
    // SERVER変数取得
    protected static function getServerInfo($key) {
        return $_SERVER[$key];
    }
}
