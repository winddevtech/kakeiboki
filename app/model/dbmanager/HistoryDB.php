<?php
require_once dirname(__FILE__) . '/../com/MainDBModel.php';
//変更履歴DBクラス
class HistoryDB extends MainDBModel {
    // 更新履歴リストを最新10件分取得する
    public static function getList() {
        $sql = 'select * from version limit 10';
        $search_datas = parent::queryAll($sql);

        if (! $search_datas) {
            parent::outputErrlog(basename(__FILE__), __LINE__, '更新履歴取得エラー[sql='.$sql.']');
            return false;
        }

        return $search_datas;
    }

    // 登録されている更新履歴の件数を取得する
    public static function getCount(){
        $sql = 'select count(*) from version';
        $search_count = parent::queryCount($sql);

        if (! $search_count) {
            parent::outputErrlog(basename(__FILE__), __LINE__, '更新履歴件数取得エラー[sql='.$sql.']');
            return false;
        }

        return $search_count;
    }

}