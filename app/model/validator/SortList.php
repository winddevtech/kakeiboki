<?php
require_once dirname(__FILE__) . '/../const/InputConst.php';
class SortList {
    /*private static $DISPLAY_COUNT_LIST = array (
            '1' => '10', '2' => '20', '3' => '25', '4' => '30', '5' => '50', '6' => '100');*/

    // 表示件数ホワイトリスト
    public static function displayCount($value) {
        $value_safe = (! empty(InputConst::$display_count_list[$value])) ? InputConst::$display_count_list[$value] : false;
        //$value_safe = (isset(InputConst::DISPLAY_COUNT_LIST[$value])) ? InputConst::DISPLAY_COUNT_LIST[$value] : false;

        return $value_safe;
    }

    //お問い合わせカテゴリー
    public static function category($value) {
        $value_safe = (isset(InputConst::$category_white_list[$value])) ? InputConst::$category_white_list[$value] : false;

        return $value_safe;
    }

    // 用途IDをホワイトリストで照合する
    public static function useItemId($value) {
        $value_safe = (! empty(InputConst::$use_id_white_list[$value])) ? InputConst::$use_id_white_list[$value] : false;

        return $value_safe;
    }

    //
    public static function accountingList($s) {
        $sort_whitelist = array ('id' => 'id', 'date' => 'date', 'journal_id' => 'journal_id', 'price' => 'price', 'summary' => 'summary', 'created_at' => 'created_at');
        $sort_safe = (isset($sort_whitelist[$s])) ? $sort_whitelist[$s] : $sort_whitelist['id'];

        return $sort_safe;
    }
}