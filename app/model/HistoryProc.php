<?php
require_once 'com/MainProcModel.php';
require_once 'detail/History.php';
require_once 'dbmanager/HistoryDB.php';

//変更履歴クラス
class HistoryProc  extends MainProcModel {

    // 更新履歴リストを最新10件分取得する
    public static function getList() {
        $historyList = array ();

        $search_datas = HistoryDB::getList();

        if (! $search_datas) {
            return false;
        }

        // 詳細クラスに格納してリストに入れる
        foreach ($search_datas as $row) {
            $histryDetailObj = new History();
            $histryDetailObj->setId($row['id']);
            $histryDetailObj->setNumber($row['number']);
            $histryDetailObj->setContext($row['context']);
            $histryDetailObj->setCreatedAt($row['created_at']);
            $histryDetailObj->setUpdatedAt($row['updated_at']);
            array_push($historyList, $histryDetailObj);
        }

        return $historyList;
    }

    // 更新履歴リストを最新10件分取得する
    public static function getCount() {
        return HistoryDB::getCount();
    }
}