<?php
require_once dirname(__FILE__) . '/../../app/model/detail/Contact.php';
require_once dirname(__FILE__) . '/../../app/model/detail/Timeline.php';
require_once dirname(__FILE__) . '/../../app/model/const/InputConst.php';
require_once dirname(__FILE__) . '/../../app/model/dbmanager/ContactDB.php';
//require_once 'db/DBManager.php';
require_once 'com/MainProcModel.php';
// お問い合わせ内容設定クラス
class ReplyProc extends MainProcModel {


    //管理者用ホワイトリスト
    public static function sortWhiteListAd($s){
        $sort_whitelist = array ('id' => 'id', 'created_at' => 'created_at', 'updated_at' => 'updated_at',
                'name' => 'name', 'rs_id' => 'rs_id');
        $sort_safe = (isset($sort_whitelist[$s])) ? $sort_whitelist[$s] : $sort_whitelist['id'];

        return $sort_safe;
    }


    // 管理者用返信リスト
    public static function getReplyListByKeyword($keyword, $sort_safe, $order_safe, $offset) {
        $searchDatas = ContactDB::getReplyListByKeyword($keyword, $sort_safe, $order_safe, $offset);

        if (! $searchDatas) {
            return false;
        }

        return self::setReplyList($searchDatas);
    }

    // 管理者用返信リスト数
    public static function getReplyListCountByKeyword($keyword){
        return ContactDB::getReplyListCountByKeyword($keyword);
    }

    private static function setReplyList($searchDatas){
        $replyObjList = array();
        // 詳細クラスに格納してリストに入れる
        foreach ($searchDatas as $row) {
            $contactDetailObj = new Contact();
            $contactDetailObj->setId($row['id']);
            $contactDetailObj->setUserId($row['name']);
            $contactDetailObj->setReplyStatusId($row['rs_id']);
            $contactDetailObj->setCreatedAt($row['created_at']);
            $contactDetailObj->setUpdatedAt($row['updated_at']);
            array_push($replyObjList, $contactDetailObj);
        }
        return $replyObjList;
    }



}