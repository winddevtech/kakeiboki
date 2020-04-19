<?php
require_once dirname(__FILE__) . '/../com/MainDBModel.php';
//テーブル結合クラス
class JoinDB extends MainDBModel {
    // 家計簿データリストを取得する
    public static function getBudgetListByDateAndUseItem($user_id, $start_date, $end_date, $use_item, $sort_safe, $order_safe, $offset, $count) {
        // 指定位置から10件取得する
        $sql = 'select id, date, journal_id, price, summary from budget ';
        $sql = $sql . 'where user_id = :user_id and date_format(`date`,"%Y-%m-%d") between :start_date and :end_date and ';
        $sql = $sql . 'journal_id = :journal_id order by ' . $sort_safe . ' ' . $order_safe . ' limit :offset, :count';
        $query_arg = array (
                ':user_id' => array ($user_id, PDO::PARAM_INT),
                ':start_date' => array ($start_date, PDO::PARAM_STR),
                ':end_date' => array ($end_date, PDO::PARAM_STR),
                ':journal_id' => array ($use_item, PDO::PARAM_INT),
                ':offset' => array ($offset, PDO::PARAM_INT),
                ':count' => array ($count, PDO::PARAM_INT)
        );
        $search_rows = parent::queryAll($sql,$query_arg);

        return self::setSearchRowData($search_rows);;
    }

    // 登録されているお問い合わせの件数を取得する
    public static function getBudgetCountByDateAndUseItem($user_id, $start_date, $end_date, $use_item){
        $sql = 'select count(*) from budget where user_id = :user_id and ';
        $sql = $sql . 'date_format(`date`,"%Y-%m-%d") between :start_date and :end_date and journal_id = :journal_id';
        $query_arg = array (
                ':user_id' => array ($user_id, PDO::PARAM_INT),
                ':start_date' => array ($start_date, PDO::PARAM_STR),
                ':end_date' => array ($end_date, PDO::PARAM_STR),
                ':journal_id' => array ($use_item, PDO::PARAM_INT)
        );
        $search_count = parent::queryCount($sql, $query_arg);

        return $search_count;
    }

    // 家計簿データリストを取得する
    public static function getBudgetListByDate($user_id, $start_date, $end_date ,$sort_safe, $order_safe, $offset, $count) {
        // 指定位置から10件取得する
        $sql = 'select id, date, journal_id, price, summary from budget where user_id = :user_id and ';
        $sql = $sql . 'date_format(`date`,"%Y-%m-%d") between :start_date and :end_date ';
        $sql = $sql . 'order by ' . $sort_safe . ' ' . $order_safe . ' limit :offset, :count';
        $query_arg = array (
                ':user_id' => array ($user_id, PDO::PARAM_INT),
                ':start_date' => array ($start_date, PDO::PARAM_STR),
                ':end_date' => array ($end_date, PDO::PARAM_STR),
                ':offset' => array ($offset, PDO::PARAM_INT),
                ':count' => array ($count, PDO::PARAM_INT)
        );
        $search_rows = parent::queryAll($sql,$query_arg);

        return self::setSearchRowData($search_rows);
    }

    // 登録されているお問い合わせの件数を取得する
    public static function getBudgetCountByDate($user_id, $start_date, $end_date){
        $sql = 'select count(*) from budget where user_id = :user_id and ';
        $sql = $sql . 'date_format(`date`,"%Y-%m-%d") between :start_date and :end_date';
        $query_arg = array (
                ':user_id' => array ($user_id, PDO::PARAM_INT),
                ':start_date' => array ($start_date, PDO::PARAM_STR),
                ':end_date' => array ($end_date, PDO::PARAM_STR)
        );
        $search_count = parent::queryCount($sql, $query_arg);

        return $search_count;
    }

    // 家計簿データリストを取得する
    public static function getBudgetListByUseItem($user_id, $use_item, $sort_safe, $order_safe, $offset, $count) {
        // 指定位置から10件取得する
        $sql = 'select id, date, journal_id, price, summary from budget where user_id = :user_id and ';
        $sql = $sql . 'journal_id = :journal_id order by ' . $sort_safe . ' ' . $order_safe . ' limit :offset, :count';
        $query_arg = array (
                ':user_id' => array ($user_id, PDO::PARAM_INT),
                ':journal_id' => array ($use_item, PDO::PARAM_INT),
                ':offset' => array ($offset, PDO::PARAM_INT),
                ':count' => array ($count, PDO::PARAM_INT)
        );
        $search_rows = parent::queryAll($sql,$query_arg);

        return self::setSearchRowData($search_rows);
    }

    // 登録されているお問い合わせの件数を取得する
    public static function getBudgetCountByUseItem($user_id, $use_item){
        $sql = 'select count(*) from budget where user_id = :user_id and journal_id = :journal_id';
        $query_arg = array (
                ':user_id' => array ($user_id, PDO::PARAM_INT),
                ':journal_id' => array ($use_item, PDO::PARAM_INT)
        );
        $search_count = parent::queryCount($sql, $query_arg);

        return $search_count;
    }

    // 家計簿データリストを取得する
    public static function getBudgetList($user_id, $sort_safe, $order_safe, $offset, $count) {
        // 指定位置から10件取得する
        $sql = 'select id, date, journal_id, price, summary from budget where user_id = :user_id ';
        $sql = $sql . 'order by ' . $sort_safe . ' ' . $order_safe . ' limit :offset, :count';
        $query_arg = array (
                ':user_id' => array ($user_id, PDO::PARAM_INT),
                ':offset' => array ($offset, PDO::PARAM_INT),
                ':count' => array (intval($count), PDO::PARAM_INT)
        );
        $search_rows = parent::queryAll($sql, $query_arg);

        return self::setSearchRowData($search_rows);
    }

    // 登録されているお問い合わせの件数を取得する
    public static function getBudgetCount($user_id){
        $sql = 'select count(*) from budget where user_id = :user_id';
        $query_arg = array (
                ':user_id' => array ($user_id, PDO::PARAM_INT)
        );
        $search_count = self::queryCount($sql, $query_arg);

        return $search_count;
    }
}