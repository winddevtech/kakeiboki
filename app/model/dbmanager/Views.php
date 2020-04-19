<?php
require_once dirname(__FILE__) . '/../com/MainDBModel.php';
//ビュークラス
class Views extends MainDBModel {



    public static function getCreditList($date, $user_id){
        $sql = 'select * from credit_list where date like :date and user_id = :user_id';

        $query_arg = array (
                ':date' => array ($date, PDO::PARAM_STR),
                ':user_id' => array ($user_id, PDO::PARAM_STR)
        );

        $searchRows = parent::queryAll($sql, $query_arg);

        return $searchRows;
    }

    public static function getDebitList($date, $user_id){
        $sql = 'select * from debit_list where date like :date and user_id = :user_id';

        $query_arg = array (
                ':date' => array ($date, PDO::PARAM_STR),
                ':user_id' => array ($user_id, PDO::PARAM_STR)
        );

        $searchRows = parent::queryAll($sql, $query_arg);

        return $searchRows;
    }



}