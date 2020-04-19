<?php
// 文字列処理をまとめたクラス
class StrProc {
    // 日付を「-」から「/」にする
    public static function convDateToSlash($str){
        return str_replace('-', '/', $str);
    }
    
    // 日付を「/」から「-」にする
    public static function convDateToHyphen($str){
        return str_replace('/', '-', $str);
    }
    
    //パスワード文字列を「*」文字列にする
    public static function confirmPassword($str) {
        return str_pad('', strlen($str), '*', STR_PAD_LEFT);
    }
    
    public static function formatDateToTimestamp($timestamp) {
        return date('Y-m-d H:i:s', $timestamp);
    }
    
    public static function getTimeStampStr(){
        return date('Y-m-d H:i:s');
    }
}
