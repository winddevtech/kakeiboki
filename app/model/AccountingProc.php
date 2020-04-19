<?php

require_once 'detail/Budget.php';
require_once 'detail/TrialBalance.php';
require_once 'detail/Bspl.php';
require_once 'const/InputConst.php';
require_once 'dbmanager/BudgetDB.php';
require_once 'com/MainProcModel.php';
// 会計処理クラス
class AccountingProc extends MainProcModel {
    //バリデーション
    public static function valid($formObj){
        return parent::validForm('Accounting', $formObj);
    }


    // 検索手順1 検索条件のタイプを取得する
    public static function getSearchType($formObj) {
        $SEARCH_DATE_USEITEM = 'AccountingSearchDateUseItem';
        $SEARCH_DATE = 'AccountingSearchDate';
        $SEARCH_USEITEM = 'AccountingSearchUseItem';
        $SEARCH_NOMAL = 'AccountingSearch';

        $isStartDate = $formObj->hasErr('start_date');
        $isStartEnd = $formObj->hasErr('end_date');
        $safeUseItemId = $formObj->hasErr('use_item_id');

        require_once 'dbmanager/accounting/AccountingSearch.php';

        if ($isStartDate && $isStartEnd && $safeUseItemId) {
            return $SEARCH_DATE_USEITEM;
        }

        if ($isStartDate && $isStartEnd || $isStartDate) {
            return $SEARCH_DATE;
        }

        if ($safeUseItemId) {
            return $SEARCH_USEITEM;
        }

        return $SEARCH_NOMAL;
    }


    // 検索手順2 DB検索用パラメータを取得する
    public static function preGetData ($className, $start_date, $end_date, $use_item_id){
        $params = array('start_date' => $start_date, 'end_date' => $end_date, 'use_item_id' => $use_item_id);
        $methodName = 'preGetData';
        $searchParamArray = $className::$methodName($params);
        return $searchParamArray;
    }

    // 検索手順3 家計簿情報のオブジェクトリストを取得する
    public static function getBudgetObjectList($className, $userId, $sort_safe, $order_safe, $offset, $display_count_safe, $params){
        $methodName = 'getBudgetList';
        $budgetObjList = $className::$methodName($userId, $sort_safe, $order_safe, $offset, $display_count_safe, $params);
        return self::setSearchRowData($budgetObjList);
    }

    // 検索手順4 家計簿情報件数を取得する
    public static function getBudgetTotal($className, $userId, $params) {
        $methodName = 'getBudgetCount';
        $total = $className::$methodName($userId, $params);
        return $total;
    }

    // 検索手順5 検索用URLパラメータを取得する
    public static function getSearchParamArray ($className, $start_date, $end_date, $use_item_id){
        $methodName = 'getSearchParamArray';
        $searchParamArray = $className::$methodName($start_date, $end_date, $use_item_id);
        return $searchParamArray;
    }

    // 表示件数ホワイトリスト
    public static function displayCountWhiteList($value) {
        require_once 'validator/SortList.php';
        return SortList::displayCount($value);
    }

    // 用途IDをホワイトリストで照合する
    private static function useItemIdWhiteList($use_item_id) {
        require_once 'validator/SortList.php';
        return SortList::useItemId($use_item_id);
    }

    //プルダウンの日付形式か判定する
    public static function isFormatCalenderDate($value){
        require_once dirname(__FILE__) . '/../../framework/Validation.php';
        require_once 'validator/ValidAccounting.php';
        return ValidAccounting::validFormatCalenderDate($value);
    }

    private static function setSearchRowData($search_rows){
        $budget_list = array ();
        // 詳細クラスに格納してリストに入れる
        foreach ($search_rows as $row) {
            $budget_detail_obj = new Budget();
            $budget_detail_obj->setId($row['id']);
            $budget_detail_obj->setCreationDate(Security::h($row['date']));
            $use_item_name = self::useItemIdWhiteList(Security::h($row['journal_id']));
            $budget_detail_obj->setUseItem($use_item_name);
            $budget_detail_obj->setPrice(Security::h($row['price']));
            $budget_detail_obj->setSummary(Security::h($row['summary']));
            $budget_list[] = $budget_detail_obj;
        }
        return $budget_list;
    }

    // ソート条件（カラム名、並び順）をホワイトリストで照合する
    public static function sortWhiteList($s) {
        require_once 'validator/SortList.php';
        $sort_safe = SortList::accountingList($s);

        return $sort_safe;
    }

    //出力年月の連想配列を生成する
    public static function generatedOutPutArray($user_id){
        $outputDateRows = BudgetDB::getOutPutDate($user_id);

        //出力年月の連想配列を生成
        $outputDateArray = array();
        foreach ($outputDateRows as $row) {
            $outputDateArray += array($row['date'] => $row['date']);
        }

        return $outputDateArray;
    }

    //カレンダー表示用データを取得する
    public static function getCalenderData($search_date, $user_id) {
        $budget_list = array ();

        $calenderDateRows = BudgetDB::getCalenderData($search_date, $user_id);

        foreach ($calenderDateRows as $row) {
            array_push($budget_list, array ($row['date'], $row['count']));
        }

        return $budget_list;
    }

    //試算表データ取得
    public static function getTbData($date, $user_id) {
        require_once 'dbmanager/Views.php';
        require_once 'dbmanager/JournalSubjectDB.php';

        $tbObjList = array ();

        $creditList = Views::getCreditList($date, $user_id);
        $debitList = Views::getDebitList($date, $user_id);

        $journalSubjectList = JournalSubjectDB::getJournalSubjectList();

        //試算表を初期化
        foreach ($journalSubjectList as $row){
            $tbObj = new TrialBalance();
            $tbObj->setSubjectId($row['id']); //仕訳科目ID
            $tbObj->setSubjectName($row['name']);//仕訳科目名
            $tbObj->setClassId($row['class_id']);//分類ID
            $tbObj->setDebitSum(0); //借方合計を初期化
            $tbObj->setCreditSum(0); //貸方合計を初期化
            array_push($tbObjList, $tbObj);
        }

        //借方合計を設定
        foreach ($debitList as $row){
            $tbObj = $tbObjList[$row['debit_id'] - 1];
            $tbObj->setDebitSum($row['debit_price']);
        }

        //貸方合計を設定
        foreach ($creditList as $row){
            $tbObj = $tbObjList[$row['credit_id'] - 1];
            $tbObj->setCreditSum($row['credit_price']);
        }

        //借方残高・貸方残高を算出
        foreach ($tbObjList as $tbObj){
            if ($tbObj->getDebitSum() >= $tbObj->getCreditSum()) {
                $tbObj->setDebitBalance($tbObj->getDebitSum() - $tbObj->getCreditSum());
                $tbObj->setCreditBalance(0);
            } else {
                $tbObj->setCreditBalance($tbObj->getCreditSum() - $tbObj->getDebitSum());
                $tbObj->setDebitBalance(0);
            }
        }

        return $tbObjList;
    }

    //決算書類データ取得
    public static function getBsPlData($date, $user_id) {
        //試算表データ取得
        $tbObjList = self::getTbData($date, $user_id);

        $bsplObjList = array ();

        //決算情報を生成
        foreach ($tbObjList as $tbObj){
            $bsplObj = new Bspl();
            $bsplObj->setClassId($tbObj->getClassId());
            $bsplObj->setSubjectName($tbObj->getSubjectName());
            if ($tbObj->getDebitBalance() > 0) {
                $bsplObj->setMoney($tbObj->getDebitBalance());
            } else {
                $bsplObj->setMoney($tbObj->getCreditBalance());
            }
            array_push($bsplObjList, $bsplObj);
        }

        return $bsplObjList;
    }


    //家計簿情報をDBから削除する
    public static function deleteBudget($budget_id){
        $isExecute = BudgetDB::deleteById($budget_id);

        return $isExecute;
    }
}