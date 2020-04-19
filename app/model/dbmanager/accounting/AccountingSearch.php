<?php
require_once dirname(__FILE__) . '/../../com/MainDBModel.php';

//家計簿情報検索クラス
interface IAccountingSearch {
    public static function getSearchParamArray($start_date, $end_date, $use_item_id); //検索用URLパラメータを取得する
    public static function preGetData($params); //前処理 DB検索用パラメータを取得する
    public static function getBudgetList($user_id, $sort_safe, $order_safe, $offset, $count, $params); // 家計簿データリストを取得する
    public static function getBudgetCount($user_id, $params); // 登録されている家計簿データの件数を取得する
}


//日付&用途ID
class AccountingSearchDateUseItem extends MainDBModel implements IAccountingSearch {
    public static function getSearchParamArray($start_date, $end_date, $use_item_id) {
        return array ('start_date' => $start_date, 'end_date' => $end_date, 'use_item_id' => $use_item_id);
    }

    public static function preGetData($params) {
        $start_date_safe = StrProc::convDateToHyphen($params['start_date']);
        $end_date_safe = StrProc::convDateToHyphen($params['end_date']);
        return array ('start_date_safe' => $start_date_safe, 'end_date_safe' => $end_date_safe, 'use_item_id' => $params['use_item_id']);
    }

    public static function getBudgetList($user_id, $sort_safe, $order_safe, $offset, $count, $params) {
        $sql = 'select id, date, journal_id, price, summary from budget ';
        $sql = $sql . 'where user_id = :user_id and date_format(`date`,"%Y-%m-%d") between :start_date and :end_date and ';
        $sql = $sql . 'journal_id = :journal_id order by ' . $sort_safe . ' ' . $order_safe . ' limit :offset, :count';
        $queryArg = array (
                ':user_id' => array ($user_id, PDO::PARAM_INT),
                ':start_date' => array ($params['start_date_safe'], PDO::PARAM_STR),
                ':end_date' => array ($params['end_date_safe'], PDO::PARAM_STR),
                ':journal_id' => array ($params['use_item_id'], PDO::PARAM_INT),
                ':offset' => array ($offset, PDO::PARAM_INT),
                ':count' => array ($count, PDO::PARAM_INT)
        );
        $searchRows = parent::queryAll($sql,$queryArg);

        return $searchRows;
    }

    public static function getBudgetCount($user_id, $params){
        $sql = 'select count(*) from budget where user_id = :user_id and ';
        $sql = $sql . 'date_format(`date`,"%Y-%m-%d") between :start_date and :end_date and journal_id = :journal_id';
        $queryArg = array (
                ':user_id' => array ($user_id, PDO::PARAM_INT),
                ':start_date' => array ($params['start_date_safe'], PDO::PARAM_STR),
                ':end_date' => array ($params['end_date_safe'], PDO::PARAM_STR),
                ':journal_id' => array ($params['use_item_id'], PDO::PARAM_INT)
        );
        $searchCount = parent::queryCount($sql, $queryArg);

        return $searchCount;
    }
}
//日付のみ
class AccountingSearchDate extends MainDBModel implements IAccountingSearch  {
    public static function getSearchParamArray($start_date, $end_date, $use_item_id) {
        return array ('start_date' => $start_date, 'end_date' => $end_date);
    }

    public static function preGetData($params) {
        $start_date = $params['start_date'];
        $end_date = $params['end_date'];

        require_once dirname(__FILE__) . '/../../../../framework/Validation.php';
        require_once dirname(__FILE__) . '/../../validator/ValidAccounting.php';

        if (! ValidAccounting::validFormatDate($end_date)) {
            $end_date = $start_date;
        }
        $start_date_safe = StrProc::convDateToHyphen($start_date);
        $end_date_safe = StrProc::convDateToHyphen($end_date);
        return array ('start_date_safe' => $start_date_safe, 'end_date_safe' => $end_date_safe);
    }

    public static function getBudgetList($user_id, $sort_safe, $order_safe, $offset, $count, $params) {
        $sql = 'select id, date, journal_id, price, summary from budget where user_id = :user_id and ';
        $sql = $sql . 'date_format(`date`,"%Y-%m-%d") between :start_date and :end_date ';
        $sql = $sql . 'order by ' . $sort_safe . ' ' . $order_safe . ' limit :offset, :count';
        $queryArg = array (
                ':user_id' => array ($user_id, PDO::PARAM_INT),
                ':start_date' => array ($params['start_date_safe'], PDO::PARAM_STR),
                ':end_date' => array ($params['end_date_safe'], PDO::PARAM_STR),
                ':offset' => array ($offset, PDO::PARAM_INT),
                ':count' => array ($count, PDO::PARAM_INT)
        );
        $searchRows = parent::queryAll($sql,$queryArg);

        return $searchRows;
    }

    public static function getBudgetCount($user_id, $params){
        $sql = 'select count(*) from budget where user_id = :user_id and ';
        $sql = $sql . 'date_format(`date`,"%Y-%m-%d") between :start_date and :end_date';
        $queryArg = array (
                ':user_id' => array ($user_id, PDO::PARAM_INT),
                ':start_date' => array ($params['start_date_safe'], PDO::PARAM_STR),
                ':end_date' => array ($params['end_date_safe'], PDO::PARAM_STR)
        );
        $searchCount = parent::queryCount($sql, $queryArg);

        return $searchCount;
    }
}
//用途IDのみ
class AccountingSearchUseItem extends MainDBModel implements IAccountingSearch  {
    public static function getSearchParamArray($start_date, $end_date, $use_item_id) {
        return array ('use_item' => $use_item_id);
    }

    public static function preGetData($params) {
        return array ('use_item_id' => $params['use_item_id']);
    }

    public static function getBudgetList($user_id, $sort_safe, $order_safe, $offset, $count, $params) {
        $sql = 'select id, date, journal_id, price, summary from budget where user_id = :user_id and ';
        $sql = $sql . 'journal_id = :journal_id order by ' . $sort_safe . ' ' . $order_safe . ' limit :offset, :count';
        $queryArg = array (
                ':user_id' => array ($user_id, PDO::PARAM_INT),
                ':journal_id' => array ($params['use_item_id'], PDO::PARAM_INT),
                ':offset' => array ($offset, PDO::PARAM_INT),
                ':count' => array ($count, PDO::PARAM_INT)
        );
        $searchRows = parent::queryAll($sql,$queryArg);

        return $searchRows;
    }
    public static function getBudgetCount($user_id, $params){
        $sql = 'select count(*) from budget where user_id = :user_id and journal_id = :journal_id';
        $queryArg = array (
                ':user_id' => array ($user_id, PDO::PARAM_INT),
                ':journal_id' => array ($params['use_item_id'], PDO::PARAM_INT)
        );
        $searchCount = parent::queryCount($sql, $queryArg);

        return $searchCount;
    }
}
//検索条件なし
class AccountingSearch extends MainDBModel implements IAccountingSearch {
    public static function getSearchParamArray($start_date, $end_date, $use_item_id) {
        return array ();
    }

    public static function preGetData($params) {
        return array ();
    }

    public static function getBudgetList($user_id, $sort_safe, $order_safe, $offset, $count, $params) {
        $sql = 'select id, date, journal_id, price, summary from budget where user_id = :user_id ';
        $sql = $sql . 'order by ' . $sort_safe . ' ' . $order_safe . ' limit :offset, :count';
        $queryArg = array (
                ':user_id' => array ($user_id, PDO::PARAM_INT),
                ':offset' => array ($offset, PDO::PARAM_INT),
                ':count' => array (intval($count), PDO::PARAM_INT)
        );
        $searchRows = parent::queryAll($sql, $queryArg);

        return $searchRows;
    }

    public static function getBudgetCount($userId, $params){
        $sql = 'select count(*) from budget where user_id = :user_id';
        $queryArg = array (
                ':user_id' => array ($userId, PDO::PARAM_INT)
        );
        $searchCount = parent::queryCount($sql, $queryArg);

        return $searchCount;
    }
}