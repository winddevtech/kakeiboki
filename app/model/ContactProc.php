<?php
require_once 'detail/Contact.php';
require_once 'detail/Timeline.php';
require_once 'const/InputConst.php';
require_once 'dbmanager/ContactDB.php';
//require_once 'db/DBManager.php';
require_once 'com/MainProcModel.php';
// お問い合わせ内容設定クラス
class ContactProc  extends MainProcModel {

    //バリデーション
    public static function valid($formObj){
        return parent::validForm('Contact', $formObj);
    }

    //カテゴリーを選択するプルダウンhtml文字列を生成する
    public static function createArrayToSelect($categoryId){
        require_once 'HtmlCreator.php';
        return HtmlCreator::createCategoryId($categoryId);
    }

    // 表示件数ホワイトリスト
    public static function displayCountWhiteList($value) {
        require_once 'validator/SortList.php';
        return SortList::displayCount($value);
    }

    //新規登録
    public static function insertContact($contactObj) {
        //$isExecute = DBManager::insert($contactObj);
        $isExecute = ContactDB::insertDB($contactObj->getUserId(), $contactObj->getCategoryId(), $contactObj->getContext());
        return $isExecute;
    }




    // カテゴリーIDホワイトリスト
    public static function categoryWhiteList($value) {
        require_once 'validator/SortList.php';
        return SortList::category($value);
    }



    // 該当ユーザーのお問い合わせ件数を取得する
    public static function getCount($user_id) {
        require_once 'dbmanager/ContactDB.php';
        return ContactDB::getCount($user_id);
    }

    public static function sortWhiteListUser($s){
        $sort_whitelist = array ('id' => 'id', 'created_at' => 'created_at', 'rs_id' => 'rs_id',
                'category_id' => 'category_id', 'context' => 'context');
        $sort_safe = (isset($sort_whitelist[$s])) ? $sort_whitelist[$s] : $sort_whitelist['id'];

        return $sort_safe;
    }

    // お問い合わせ一覧を取得する
    public static function getList($user_id, $sort_safe, $order_safe, $offset, $count) {
        require_once 'dbmanager/ContactDB.php';
        $search_datas = ContactDB::getList($user_id, $sort_safe, $order_safe, $offset, $count);

        return self::setSearchRowData($search_datas);
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