<?php
require_once dirname(__FILE__) . '/../com/MainDBModel.php';
//自動ログインDBクラス
class AutoLoginDB extends MainDBModel {


    // DBにCookieを登録する
    // 【引数】ユーザー管理ID、自動ログインキー、Cookieの有効期限
    // 【戻り値】成功時：true、失敗時：false
    public static function insertDB($user_id, $auto_login_key, $expire){
        $sql = 'insert into auto_login (user_id, c_key, expire, created_at) values (:user_id, :c_key, :expire, now())';
        $query_arg = array (
                ':user_id' => array ($user_id, PDO::PARAM_INT),
                ':c_key' => array ($auto_login_key, PDO::PARAM_STR),
                ':expire' => array ($expire, PDO::PARAM_STR)
        );
        $isExecute = parent::insert($sql, $query_arg);

        if (! $isExecute) {
            parent::outputErrlog(basename(__FILE__), __LINE__, 'Cookie登録エラー[sql='.$sql.']');
            return false;
        }

        return true;
    }

    // DB上のCookie情報を削除
    public static function deleteDB($auto_login_key) {
        $sql = 'delete from auto_login where c_key = :c_key';
        $query_arg = array (
                ':c_key' => array ($auto_login_key, PDO::PARAM_STR)
        );
        $isExecute = parent::delete($sql, $query_arg);

        if (! $isExecute) {
            parent::outputErrlog(basename(__FILE__), __LINE__, 'CookieキーによるCookie削除エラー[sql='.$sql.']');
            return false;
        }

        return true;
    }

    //ユーザーIDによる削除
    public static function deleteByUserId($user_id){
        $sql = 'delete from auto_login where user_id = :user_id';
        $query_arg = array (
                ':user_id' => array ($user_id, PDO::PARAM_INT)
        );
        $isExecute = parent::delete($sql, $query_arg);

        if (! $isExecute) {
            parent::outputErrlog(basename(__FILE__), __LINE__, 'ユーザーIDによるCookie削除エラー[sql='.$sql.']');
            return false;
        }

        return true;
    }

    // DB上にあるユーザーのCookie情報を検索する
    // 【引数】自動ログインキー
    // 【戻り値】DBに登録されてるcookie情報
    public static function getCookieInDB($auto_login_key){
        $one_year_later = date('Y-m-d H:i:s', time() + 3600 * 24 * 365); // 一年後の時刻
        $sql = 'select * from auto_login where c_key = :c_key and expire between now() and :one_year_later limit 1';
        $query_arg = array (':c_key' => array ($auto_login_key, PDO::PARAM_STR),
                ':one_year_later' => array ($one_year_later, PDO::PARAM_STR)
        );
        $search_data = parent::query($sql, $query_arg);

        if (! $search_data) {
            return false;
        }

        return $search_data;
    }

}