<?php
require_once dirname(__FILE__) . '/../com/MainDBModel.php';

//家計簿情報クラス
class BudgetDB extends MainDBModel {
    //登録処理
    public static function insertDB($user_id, $date, $journal_id, $price, $summary) {
        $sql = 'insert into budget (user_id, date, journal_id, price, summary, created_at) values (:user_id, :date, :journal_id, :price, :summary, now())';
        $query_arg = array (
                ':user_id' => array ($user_id, PDO::PARAM_INT),
                ':date' => array ($date, PDO::PARAM_STR),
                ':journal_id' => array ($journal_id, PDO::PARAM_INT),
                ':price' => array ($price, PDO::PARAM_INT),
                ':summary' => array ($summary, PDO::PARAM_STR)
        );
        $isExecute = parent::insert($sql, $query_arg);

        if (! $isExecute) {
            parent::outputErrlog(basename(__FILE__), __LINE__, '家計簿情報登録エラー[sql='.$sql.']');
            return false;
        }

        return $isExecute;
    }

    //更新処理
    public static function updateDB($user_id, $date, $journal_id, $price, $summary, $budget_id) {
        $sql = 'update budget set date = :date, journal_id = :journal_id, price = :price, summary = :summary, updated_at = now() where id = :id and user_id = :user_id';
        $query_arg = array (
                ':id' => array ($budget_id, PDO::PARAM_INT),
                ':user_id' => array ($user_id, PDO::PARAM_INT),
                ':date' => array ($date, PDO::PARAM_STR),
                ':journal_id' => array ($journal_id, PDO::PARAM_INT),
                ':price' => array ($price, PDO::PARAM_INT),
                ':summary' => array ($summary, PDO::PARAM_STR)
        );
        $isExecute = parent::update($sql, $query_arg);

        if (! $isExecute) {
            parent::outputErrlog(basename(__FILE__), __LINE__, '家計簿情報更新エラー[sql='.$sql.']');
            return false;
        }

        return $isExecute;
    }

    //ユーザーIDでの家計簿情報削除処理
    public static function deleteDB($user_id) {
        $sql = 'delete from budget where user_id = :user_id';
        $query_arg = array (
                ':user_id' => array ($user_id, PDO::PARAM_INT)
        );
        $isExecute = parent::delete($sql, $query_arg);

        if (! $isExecute) {
            parent::outputErrlog(basename(__FILE__), __LINE__, '家計簿情報ユーザーID削除エラー[sql='.$sql.']');
            return false;
        }

        return true;
    }

    //家計簿情報IDでの家計簿情報処理
    public static function deleteById($budget_id){
        $sql = 'delete from budget where id = :id';
        $query_arg = array (
                ':id' => array ($budget_id, PDO::PARAM_INT)
        );
        $isExecute = parent::delete($sql, $query_arg);

        if (! $isExecute) {
            parent::outputErrlog(basename(__FILE__), __LINE__, '家計簿情報ID削除エラー[sql='.$sql.']');
            return false;
        }

        return true;
    }

    //家計簿情報を1件管理IDで取得する
    public static function searchBudget($budget_id){
        $sql = 'select * from budget where id = :budget_id limit 1';
        $query_arg = array (
                ':budget_id' => array ($budget_id, PDO::PARAM_INT)
        );
        $searchRow = parent::query($sql, $query_arg);

        return $searchRow;
    }

    // DBに新規一括登録
    public static function insertAll($importDetailObj, $user_id) {
        $datas = $importDetailObj->getOkDataArray();

        $sql = "insert into budget (user_id, date, journal_id,  price, summary, created_at) values";

        $count = 0;
        $max = $importDetailObj->getOkDataCount();

        //登録件数分のプリペアドステートメントを生成する
        while ($count < $max) {
            $sql .= " (:user_id${count}, :date${count}, :journal_id${count}, :price${count}, :summary${count}, now())";
            if($count !== ($max - 1)){
                $sql .= ", ";
            }
            $count++;
        }

        //登録件数分のデータバインドを行う
        $query_arg = array ();
        for ($i = 0; $i < $count; $i++) {
            $query_arg[":user_id${i}"] = array ($user_id, PDO::PARAM_INT);
            $query_arg[":date${i}"] = array ($datas[$i][0], PDO::PARAM_INT);
            $query_arg[":journal_id${i}"] = array ($datas[$i][1], PDO::PARAM_INT);
            $query_arg[":price${i}"] = array ($datas[$i][2], PDO::PARAM_INT);
            $query_arg[":summary${i}"] = array ($datas[$i][3], PDO::PARAM_STR);
        }

        $isExecute = parent::insert($sql, $query_arg);

        if (! $isExecute) {
            parent::outputErrlog(basename(__FILE__), __LINE__, 'インポートエラー[sql='.$sql.']');
            return false;
        }

        return true;
    }


    //家計簿情報の登録年月を取得する
    public static function getOutPutDate($user_id){
        $sql = 'select date_format(max(`date`),"%Y/%m") as date from budget where user_id = :user_id group by date_format(`date`,"%Y/%m") order by date_format(`date`,"%Y/%m") asc';

        $query_arg = array (
                ':user_id' => array ($user_id, PDO::PARAM_STR)
        );

        $outputDateRows = parent::queryAll($sql, $query_arg);

        return $outputDateRows;
    }

    //カレンダー表示用データを取得する
    public static function getCalenderData($search_date, $user_id) {
        $sql = 'select date_format(date, "%Y/%m/%d") as date , count(*) as count from budget where user_id = :user_id group by date_format(date, "%Y/%m/%d") having date_format(date, "%Y/%m") = :search_date';
        $query_arg = array (
                ':search_date' => array ($search_date, PDO::PARAM_STR),
                ':user_id' => array ($user_id, PDO::PARAM_STR)
        );
        $calenderDateRows = parent::queryAll($sql, $query_arg);

        return $calenderDateRows;
    }

}