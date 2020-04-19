<?php
require_once 'detail/Contact.php';
require_once 'detail/Timeline.php';
require_once 'const/InputConst.php';
require_once 'dbmanager/ContactDB.php';
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
        require_once 'IconManager.php';
        return IconManager::getDisplayIcon($post_icon_img);
    }

    //タイムラインの基本情報を取得する
    public static function getTimelineBase($contact_id){
        $timeline_base = ContactDB::getTimelineBase($contact_id);

        return $timeline_base;
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
        require_once 'validator/SortList.php';
        return SortList::category($value);
    }



}