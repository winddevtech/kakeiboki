<?php
//リダイレクトクラス
class Redirect {
    private static $site_url;

    public static function setSiteUrl($site_url) {
        if (self::$site_url == null) {
            self::$site_url = $site_url;
        }
        return self::$site_url;
    }

    public static function locationTop(){
        header('Location: ' . self::$site_url);
        exit();
    }

    public static function locationHome(){
        header('Location: ' . self::$site_url . 'accounting/list');
        exit();
    }

    public static function err403(){
        header('Location: ' . self::$site_url . 'errpage/err403');
        exit();
    }

    public static function err404(){
        header('Location: ' . self::$site_url . 'errpage/err404');
        exit();
    }

    public static function err500(){
        header('Location: ' . self::$site_url . 'errpage/err500');
        exit();
    }

    public static function locationAdHome(){
        header('Location: ' . self::$site_url . 'reply/list');
        exit();
    }

    public static function locationConfirm() {
        header('Location: confirm');
        exit();
    }

    public static function locationComplete() {
        header('Location: complete');
        exit();
    }
}