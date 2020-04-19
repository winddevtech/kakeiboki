<?php
require_once dirname(__FILE__) . '/../com/MainDBModel.php';
require_once dirname(__FILE__) . '/../../../framework/libs/password.php';
//ユーザー登録クラス
class UserDB extends MainDBModel {
    //新規登録
    public static function insertDB($name, $email, $password, $display_count, $img_blob) {
        $sql = 'insert into user (name, email, password, display_count, icon, created_at) values (:name, :email, :password, :display_count, :icon, now())';
        $query_arg = array (
                ':name' => array ($name, PDO::PARAM_STR),
                ':email' => array ($email, PDO::PARAM_STR),
                ':password' => array (password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR),  // 暗号化する
                ':display_count' => array ($display_count, PDO::PARAM_INT),
                ':icon' => array ($img_blob, PDO::PARAM_LOB)
        );

        $isExecute = parent::insert($sql, $query_arg);

        if (! $isExecute) {
            parent::outputErrlog(basename(__FILE__), __LINE__, 'ユーザー情報登録エラー[sql='.$sql.']');
            return false;
        }

        return true;
    }

    //ユーザー情報更新
    public static function updateDB($id, $name, $email, $password, $display_count, $img_blob) {
        $sql = 'update user set name = :name, email = :email, password = :password, display_count = :display_count, icon = :icon, updated_at = now() where id = :id';
        $query_arg = array (
                ':name' => array ($name, PDO::PARAM_STR),
                ':email' => array ($email, PDO::PARAM_STR),
                ':password' => array (password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR),  // 暗号化する
                ':display_count' => array ($display_count, PDO::PARAM_INT),
                ':icon' => array ($img_blob, PDO::PARAM_LOB),
                ':id' => array ($id, PDO::PARAM_INT)
        );

        $isExecute = parent::update($sql, $query_arg);

        if (! $isExecute) {
            parent::outputErrlog(basename(__FILE__), __LINE__, 'ユーザー情報更新エラー[sql='.$sql.']');
            return false;
        }

        return true;
    }

    // 仮パスワードを登録する
    public static function updateKariPassword($email, $kari_password){
        $onedaylater = date('Y-m-d H:i:s', time() + 3600 * 24); // 24時間後を設定する

        $sql = 'update user set kari_password = :kari_password, kari_created_at = :kari_created_at, updated_at = now() where email = :email';
        $query_arg = array (
                ':email' => array ($email, PDO::PARAM_STR),
                ':kari_password' => array (password_hash($kari_password, PASSWORD_DEFAULT), PDO::PARAM_STR),  // 暗号化する
                ':kari_created_at' => array ($onedaylater, PDO::PARAM_STR),
        );

        $isExecute = parent::update($sql, $query_arg);

        if (! $isExecute) {
            parent::outputErrlog(basename(__FILE__), __LINE__, '仮パスワード登録エラー[sql='.$sql.']');
            return false;
        }

        return true;
    }

    // 仮パスワードを初期化する
    public static function initKariPassword($email, $password){
        $sql = 'update user set password = :password, kari_password = null, kari_created_at = null, updated_at = now() where email = :email';
        $query_arg = array (
                ':email' => array ($email, PDO::PARAM_STR),
                ':password' => array (password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR)
        );

        $isExecute = parent::update($sql, $query_arg);

        if (! $isExecute) {
            parent::outputErrlog(basename(__FILE__), __LINE__, '仮パスワード初期化エラー[sql='.$sql.']');
            return false;
        }

        return true;
    }

    // Emailでユーザー情報を取得する
    public static function getUserByEmail($email) {
        $sql = 'select * from user where email = :email limit 1';
        $query_arg = array (
                ':email' => array ($email, PDO::PARAM_STR)
        );

        $search_data = parent::query($sql, $query_arg);

        if ($search_data) {
            return $search_data;
        }

        return false;
    }

    // セッションIDと最終ログイン日時を更新する
    // 【引数】ユーザー情報管理ID、セッションID、最終ログイン日時
    // 【戻り値】DBへの更新結果（true、false）
    public static function updateUserSession($user_id, $session_id = null, $last_login_at = null) {
        $sql = 'update user set session_id = :session_id, lastlogin_at = :lastlogin_at, updated_at = now() where id = :id';
        $query_arg = array (
                ':session_id' => array ($session_id, PDO::PARAM_STR),
                ':lastlogin_at' => array ($last_login_at, PDO::PARAM_STR),
                ':id' => array ($user_id, PDO::PARAM_INT)
        );
        $isExecute = parent::update($sql, $query_arg);

        if (! $isExecute) {
            parent::outputErrlog(basename(__FILE__), __LINE__, '最終ログイン日時削除エラー[sql='.$sql.']');
            return false;
        }

        return true;
    }

    //ユーザー情報をDBから削除する
    public static function deleteUser($user_id){
        $sql = 'delete from user where id = :user_id';
        $query_arg = array (
                ':user_id' => array ($user_id, PDO::PARAM_INT)
        );

        $isExecute = parent::delete($sql, $query_arg);

        if (! $isExecute) {
            parent::outputErrlog(basename(__FILE__), __LINE__, 'ユーザー情報削除エラー[sql='.$sql.']');
            return false;
        }

        return true;
    }

    // ユーザIDでユーザ情報を取得する
    // 【引数】ユーザID
    // 【戻り値】成功時：ユーザ情報、失敗時：false
    public static function getUserbyUserId($user_id){
        $sql = 'select * from user where id = :id limit 1';
        $query_arg = array (
                ':id' => array ($user_id, PDO::PARAM_INT)
        );
        $search_data = parent::query($sql, $query_arg);

        if ($search_data) {
            return $search_data;
        }

        return false;
    }
}