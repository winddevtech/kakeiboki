<?php
require_once 'dbmanager/UserDB.php';
require_once dirname(__FILE__) . '/../../framework/Cookie.php';

//cookie管理クラス
class CookieManager {

    public static function isHasCookie() {
        return Cookie::isHasCookie(COOKIE_NAME);
    }

    public static function getCookie() {
        return Cookie::getAutoLoginKey(COOKIE_NAME);
    }

    //Cookieを削除する
    public static function delete() {
        Cookie::destroy(COOKIE_NAME, COOKIE_EFFECT_PATH);
    }

    public static function init($sessionName) {
        Cookie::destroy($sessionName, COOKIE_EFFECT_PATH);
    }


    //ブラウザのcookieを削除する
   /* public static function delete($sessionName) {
        //cookieは設定されているか
        if (Cookie::isHasCookie(COOKIE_NAME)) {
            Cookie::destroy(COOKIE_NAME, COOKIE_EFFECT_PATH);
        }

        //cookieを初期化
        if(Cookie::isHasCookie($sessionName)){
            Cookie::destroy($sessionName, COOKIE_EFFECT_PATH);
        }
    }*/

    public static function generateCookieKey() {
        return Cookie::generateAutoLoginKey();
    }

    public static function generateExpire() {
        return Cookie::generateExpire();
    }

    public static function setCookie($auto_login_key, $expire) {
        Cookie::setCookie(COOKIE_NAME, $auto_login_key, $expire, COOKIE_EFFECT_PATH);
    }





}