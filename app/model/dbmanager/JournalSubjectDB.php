<?php
require_once dirname(__FILE__) . '/../com/MainDBModel.php';
//
class JournalSubjectDB extends MainDBModel {

    //仕訳科目データを取得する
    public static function getJournalSubjectList(){
        $sql = 'select id, class_id, name from journal_subject';

        $search_row = parent::queryAll($sql);

        return $search_row;
    }

}