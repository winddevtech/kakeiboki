<?php
require_once 'dbmanager/BudgetDB.php';
require_once 'com/MainProcModel.php';

//家計簿情報設定クラス
class BudgetProc extends MainProcModel {
    //バリデーション
    public static function valid($formObj){
        return parent::validForm('Budget', $formObj);
    }

    //新規登録
    public static function insertBudget($budgetObj) {
        $isExecute = BudgetDB::insertDB($budgetObj->getUserId(), $budgetObj->getCreationDate(), $budgetObj->getUseItem(), $budgetObj->getPrice(), $budgetObj->getSummary());

        return $isExecute;
    }

    //更新処理
    public static function updateBudegt($budgetObj) {
        $isExecute = BudgetDB::updateDB($budgetObj->getUserId(), $budgetObj->getCreationDate(), $budgetObj->getUseItem(), $budgetObj->getPrice(), $budgetObj->getSummary(), $budgetObj->getId());

        return $isExecute;
    }

    //用途選択のプルダウンhtml文字列を生成する
    public static function createArrayToSelect($useItemId){
        require_once 'HtmlCreator.php';
        return HtmlCreator::createUseItemSelect($useItemId);
    }

    public static function transaction($userId, $actionName) {
        return parent::transaction($userId, $actionName);
    }

    /*
     * 用途IDホワイトリスト
     */
    public static function useIdWhiteList($use_item_id) {
        require_once 'validator/SortList.php';
        return SortList::useItemId($use_item_id);
    }

    /*
     * 仕訳結果IDホワイトリスト
     */
    public static function journalIdWhiteList($value) {
        $value_safe = (isset(InputConst::$journal_subject_id_white_list[$value])) ? InputConst::$journal_subject_id_white_list[$value] : false;

        return $value_safe;
    }

    public static function getJournalInfo($journal_id){
        require_once 'dbmanager/JournalDB.php';

        return JournalDB::getJournalInfo($journal_id);
    }

    //家計簿情報を1件管理IDで取得する
    public static function searchBudget($budget_id){
        $searchRow = BudgetDB::searchBudget($budget_id);

        if ($searchRow) {
            $budget_detail_obj = new Budget();
            $budget_detail_obj->setId($searchRow['id']);
            $budget_detail_obj->setCreationDate($searchRow['date']);
            $budget_detail_obj->setUseItem($searchRow['journal_id']);
            $budget_detail_obj->setPrice($searchRow['price']);
            $budget_detail_obj->setSummary($searchRow['summary']);
            return $budget_detail_obj;
        }

        return false;
    }



}