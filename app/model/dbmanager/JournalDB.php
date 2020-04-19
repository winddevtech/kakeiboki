<?php
require_once dirname(__FILE__) . '/../com/MainDBModel.php';
//
class JournalDB extends MainDBModel {

    //仕訳結果データを取得する
    public static function getJournalInfo($journal_id){
        $sql = 'select debit_id, credit_id from journal where id = :id limit 1';
        $query_arg = array (
                ':id' => array ($journal_id, PDO::PARAM_INT)
        );
        $search_row = parent::query($sql, $query_arg);

        if (! $search_row) {
            parent::outputErrlog(basename(__FILE__), __LINE__, '仕訳結果データ取得エラー[sql='.$sql.']');
            return false;
        }

        return $search_row;
    }

}