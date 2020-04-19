<?php

require_once dirname(__FILE__) . '/../com/MainDBModel.php';
// トランザクションDBクラス
class TransactionDB extends MainDBModel {

    // トランザクション登録
    public static function insert($user_id, $content) {
        $sql = 'insert into transaction (user_id, content, created_at) values (:user_id, :content, now())';

        $query_arg = array (
                ':user_id' => array ($user_id, PDO::PARAM_STR),
                ':content' => array ($content, PDO::PARAM_STR)
        );

        $isExecute = parent::insert($sql, $query_arg);

        if (! $isExecute) {
            parent::outputErrlog(basename(__FILE__), __LINE__, 'トランザクション登録エラー[sql='.$sql.']');
            return false;
        }

        return true;
    }

    //ユーザーIDによるDB削除
    public static function deleteDB($user_id){
        $sql = 'delete from transaction where user_id = :user_id';
        $query_arg = array (
                ':user_id' => array ($user_id, PDO::PARAM_INT)
        );

        $isExecute = parent::delete($sql, $query_arg);

        if (! $isExecute) {
            parent::outputErrlog(basename(__FILE__), __LINE__, 'トランザクション削除エラー[sql='.$sql.']');
            return false;
        }

        return true;
    }
}