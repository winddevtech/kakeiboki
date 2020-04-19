<?php

//ユーザー登録クラス
class Signup {
    //ユーザー情報新規登録
    public static function insert($name, $email, $password, $display_count, $img_blob) {
        require_once dirname(__FILE__) . '/../../framework/libs/password.php';

        $sql = 'insert into user (name, email, password, display_count, icon, created_at) values (:name, :email, :password, :display_count, :icon, now())';
        $query_arg = array (
                ':name' => array ($name, PDO::PARAM_STR),
                ':email' => array ($email, PDO::PARAM_STR),
                ':password' => array (password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR),  // 暗号化する
                ':display_count' => array ($display_count, PDO::PARAM_INT),
                ':icon' => array ($img_blob, PDO::PARAM_LOB)
        );

        $result_flg = self::insert($sql, $query_arg);

        if ($result_flg) {
            return true;
        } else {
            self::outputErrlog(basename(__FILE__), __LINE__, 'ユーザー情報登録エラー[sql='.$sql.']');
            return false;
        }
    }

}