<?php
require_once dirname(__FILE__) . '/../../app/model/detail/Contact.php';
require_once dirname(__FILE__) . '/../../app/model/detail/Timeline.php';
require_once dirname(__FILE__) . '/../../app/model/const/InputConst.php';
require_once dirname(__FILE__) . '/../../app/model/dbmanager/ContactDB.php';
//require_once 'db/DBManager.php';
require_once 'com/MainProcModel.php';
// タイムライン設定クラス
class TimelineProc  extends MainProcModel {

    //バリデーション
    public static function valid($formObj){
        return parent::validForm('Timeline', $formObj);
    }

    //アイコンが設定されていなければ初期アイコンを表示する
    public static function getDisplayIcon($post_icon_img){
        require_once dirname(__FILE__) . '/../../app/model/IconManager.php';
        return IconManager::pullIconFromDB($post_icon_img);
    }

    //タイムラインを取得する
    public static function getTimeline($contact_id){
        $timeline_list = ContactDB::getTimeline($contact_id);

        return $timeline_list;
    }

    //タイムラインを追加する
    public static function addTimeline($contact_id, $sender, $context){
        $isExecute = ContactDB::addTimeline($contact_id, $sender, $context);

        return $isExecute;
    }

    // カテゴリーIDホワイトリスト
    public static function categoryWhiteList($value) {
        require_once dirname(__FILE__) . '/../../app/model/validator/SortList.php';
        return SortList::category($value);
    }

    //タイムラインの基本情報を取得する
    public static function getTimelineBaseForReply($contact_id){
        return ContactDB::getTimelineBaseForReply($contact_id);
    }

    private static function setSearchRowData($search_rows){
        $contact_obj_list = array();
        // 詳細クラスに格納してリストに入れる
        foreach ($search_rows as $row) {
            $contact_detail_obj = new Contact();
            $contact_detail_obj->setId($row['id']);
            $contact_detail_obj->setCategoryId($row['category_id']);
            $category_name = self::categoryWhiteList($row['category_id']);
            $contact_detail_obj->setCategoryName($category_name);
            $context = mb_strimwidth($row['context'], 0, 36, '...','UTF-8');
            $contact_detail_obj->setContext(Security::h($context));
            $contact_detail_obj->setReplyStatusId($row['rs_id']);
            $contact_detail_obj->setCreatedAt($row['created_at']);
            array_push($contact_obj_list, $contact_detail_obj);
        }

        return $contact_obj_list;
    }
}