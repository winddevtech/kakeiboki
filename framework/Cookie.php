<?php
/*
 * COOKIE管理クラス
 */
class Cookie {
    //cookieを設定
    public static function setCookie($name, $auto_login_key, $expire, $effect_path) {
        setcookie($name, $auto_login_key, $expire, $effect_path);
    }
    
    // Cookie情報を破棄
    public static function destroy($name, $effect_path) {
        setcookie($name, '', time() - 86400, $effect_path);
    }
    
    //指定したcookieはあるか
    public static function isHasCookie($name) {
        if (isset($_COOKIE[$name])) {
            return true;
        }
        return false;
    }
    
    //指定したcookieに保存されている値を取得
    public static function getAutoLoginKey($name) {
        return $_COOKIE[$name];
    }
    
    //cookieに保存する自動ログインキーを生成
    public static function generateAutoLoginKey(){
        return sha1(uniqid(mt_rand(), true));
    }
    
    public static function generateExpire() {
        return time() + 3600 * 24 * 365;
    }
}
