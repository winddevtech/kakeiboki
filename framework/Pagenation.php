<?php
// ページネーション生成クラス
class Pagenation {
    private static $display_page_count = 10; // 表示できる最大ページ数
    private static $page_count; //1ページに表示する件数
    
    
    public static function setPageCount($page_count = 10){
        self::$page_count = $page_count;
    }
    
    // ページネーションのHTMLタグ文字列を生成する
    // 【引数】ソート基準のカラム名、並べ方（ascかdesc）合計ページ数、表示ページ番号
    // 【戻り値】ページネーションタグの連結文字列
    public static function generatePagination($sort_safe, $order_safe, $page_num, $total_page, $search_param_array = array()){
        $pagenation_str = '<ul class="pagination">'; // ページネーションタグの連結文字列
        $page_counter = 1; // ページ数カウンター
        $search_param_str = ''; //検索パラメータ文字列
        
        // 合計ページ数は10ページよりも多いか
        if ($total_page > self::$display_page_count) {
            $total_page = self::$display_page_count;
        }
        
        //検索パラメータはあるか
        if (! empty($search_param_array)) {
            $search_param_str = self::generateSearchStr($search_param_array); //検索パラメータ文字列生成
        }
    
        // 前ページボタンを生成（表示ページ番号が1なら押下不可にする）
        // 表示ページ番号は1以上か
        if (1 < $page_num) {
            $pagenation_str = $pagenation_str . '<li><a href="?s=' . $sort_safe . '&amp;o=' . $order_safe. '&amp;page=' . ($page_num - 1);
            $pagenation_str = $pagenation_str . $search_param_str . '"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>';
        } else {
            $pagenation_str = $pagenation_str . '<li class="disabled"><a><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>';
        }
    
        // ページ番号ボタンを生成（ページの数だけ生成する）
        while ($page_counter <= $total_page) {
            // ページ数カウンターと表示させるページ番号は同じか
            if ($page_counter == $page_num) {
                $pagenation_str = $pagenation_str . '<li class="active">';
            } else {
                $pagenation_str = $pagenation_str . '<li>';
            }
            $pagenation_str = $pagenation_str . '<a href="?s=' . $sort_safe . '&amp;o=' . $order_safe. '&amp;page=' . $page_counter;
            $pagenation_str = $pagenation_str . $search_param_str . '">' . $page_counter . '</a></li>';
    
            $page_counter += 1;
        }
    
        // 次ページボタンを生成（表示ページ番号が最終ページなら押下不可にする）
        // 表示ページ番号は合計ページ数以下か
        if ($page_num < $total_page) {
            $pagenation_str = $pagenation_str . '<li><a href="?s=' . $sort_safe . '&amp;o=' . $order_safe . '&amp;page=' . ($page_num + 1);
            $pagenation_str = $pagenation_str . $search_param_str . '"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>';
        } else {
            $pagenation_str = $pagenation_str . '<li class=\'disabled\'><a><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>';
        }
        
        $pagenation_str = $pagenation_str.'</ul>';
    
        return $pagenation_str;
    }
    
    //検索パラメータ文字列生成
    private static function generateSearchStr($search_param_array) {
        $str = '';
        foreach ($search_param_array as $key => $value) {
            $str = $str . '&amp;' . $key . '=' . $value;
        }
        
        return $str;
    }
    
    
    //ソートアイコンのHTMLタグ文字列を生成する
    public static function generateSortIcon($order_safe){
        $arrow_icon = '<i class="fa fa-arrow-up" aria-hidden="true"></i>';
        
        if ($order_safe == 'desc'){
            $arrow_icon = '<i class="fa fa-arrow-down" aria-hidden="true"></i>';
        }
        
        return $arrow_icon;
    }
    
    // ソート条件（並び順）をホワイトリストで照合する
    public static function orderWhitelist($o){
        $order_whitelist = array ('asc' => 'asc', 'desc' => 'desc');
        $order_safe = (isset($order_whitelist[$o])) ? $order_whitelist[$o] : $order_whitelist['asc'];
    
        return $order_safe;
    }
    
    // ソート条件（並び順）を変更する
    public static function changeOrder($o){
        $order_safe = ($o == 'asc') ? 'desc' : 'asc';
        
        return $order_safe;
    }
    
    //データ表示開始番号を算出する
    public static function calcOffset($page_num){
        return self::$page_count * ($page_num - 1); // データ表示開始番号 = 1ページに表示する件数 * （ページ番号 - 1）
    }
    
    //合計ページ数を算出する
    public static function calcTotalPage($total){
        return ceil($total / self::$page_count); // 合計ページ数 = 登録件数 / 1ページに表示する件数
    }
}
