<?php
require_once 'com/MainController.php';
require_once dirname(__FILE__) . '/../../framework/Util.php';
require_once dirname(__FILE__) . '/../../framework/StrProc.php';
require_once dirname(__FILE__) . '/../model/AccountingProc.php';
require_once dirname(__FILE__) . '/../model/com/Form.php';
// 会計コントローラー
class AccountingController extends MainController {
    public function __construct() {
        parent::__construct();
    }
    public function preAction() {
        if (! $this->session->has('login_user_obj')) {
            Redirect::locationTop();
        }
        parent::preAction();
    }

    /**
     * 仕訳帳画面
     */
    public function listAction() {
        require_once dirname(__FILE__) . '/../../framework/Pagenation.php';

        $sort_safe = '';
        $order_safe = '';
        $arrow_icon = '';
        $total = '';
        $total_page = '';
        $offset = '';
        $pagination_str = '';
        $use_item_id = '';
        $search_param_array = array ();
        $msg_flg = false;
        $budget_obj_list = '';

        // GETデータを取得
        $get_item = $this->request->getQuery();
        $start_date = (isset($get_item['start_date'])) ? Request::trimReqSpaceHerf($get_item['start_date']) : '';
        $end_date = (isset($get_item['end_date'])) ? Request::trimReqSpaceHerf($get_item['end_date']) : '';
        $use_item_id = (isset($get_item['use_item'])) ? Request::trimReqSpaceHerf($get_item['use_item']) : '';
        $s = (isset($get_item['s'])) ? Request::trimReqSpaceHerf($get_item['s']) : '';
        $o = (isset($get_item['o'])) ? Request::trimReqSpaceHerf($get_item['o']) : 'asc';
        $page_num = (isset($get_item['page'])) ? Request::trimReqSpaceHerf($get_item['page']) : 1;
        $d = (isset($get_item['d'])) ? Request::trimReqSpaceHerf($get_item['d']) : '';

        // GETデータチェック
        $sort_safe = AccountingProc::sortWhiteList($s);
        $order_safe = Pagenation::orderWhitelist($o);

        $display_count_safe = AccountingProc::displayCountWhiteList($this->login_user_obj->getDispCount());
        $display_count_safe = intval($display_count_safe);

        // 1ページに表示する件数を設定する
        Pagenation::setPageCount($display_count_safe);

        // 家計簿情報の取得位置を計算する
        $offset = Pagenation::calcOffset($page_num);

        //フォームオブジェクトを作成
        $form_obj = new Form();
        $form_obj->addParam('start_date', $start_date);
        $form_obj->addParam('end_date', $end_date);
        $form_obj->addParam('use_item_id', $use_item_id);

        //検索パラメータのチェックを行う
        $form_obj = AccountingProc::valid($form_obj);

        // 家計簿情報の検索タイプを取得する
        $searchType = AccountingProc::getSearchType($form_obj);

        //DB検索用パラメータを取得する
        $preParam = AccountingProc::preGetData($searchType, $start_date, $end_date, $use_item_id);

        //家計簿情報のオブジェクトリストを取得する
        $budget_obj_list = AccountingProc::getBudgetObjectList($searchType, $this->login_user_obj->getId(), $sort_safe, $order_safe, $offset, $display_count_safe, $preParam);

        // 家計簿情報件数を取得する
        $total = AccountingProc::getBudgetTotal($searchType, $this->login_user_obj->getId(), $preParam);

        // 検索用URLパラメータを取得する
        $search_param_array = AccountingProc::getSearchParamArray($searchType, $start_date, $end_date, $use_item_id);

        // 検索結果は1件以上か
        if (0 < $total) {
            // 検索した仕訳データ件数を取得する
            $total_page = Pagenation::calcTotalPage($total);

            // ソートアイコンHTML文字列
            $arrow_icon = Pagenation::generateSortIcon($order_safe);

            // ページネーションHTML文字列
            $pagination_str = Pagenation::generatePagination($sort_safe, $order_safe, $page_num, $total_page, $search_param_array);

            // ソート条件（並び順）を変更する
            $order_safe = Pagenation::changeOrder($o);
        }

        // 借方を選択するプルダウンhtml文字列を生成する
        $subject_select_html = Util::arrayToSelectGroup(array ('name' => 'use_item', 'id' => 'use_item',
                'class' => 'ctl-select form-item-large'), InputConst::$use_item_select_list, $use_item_id);

        // データ出力
        $this->view->assign('subject_select_html', $subject_select_html);
        $this->view->assign('budget_obj_list', $budget_obj_list);
        $this->view->assign('start_date', Security::h($start_date));
        $this->view->assign('end_date', Security::h($end_date));
        $this->view->assign('use_item', Security::h($use_item_id));
        $this->view->assign('sort_safe', $sort_safe);
        $this->view->assign('order_safe', $order_safe);
        $this->view->assign('arrow_icon', $arrow_icon);
        $this->view->assign('total_page', $total_page);
        $this->view->assign('offset', $offset);
        $this->view->assign('pagination_str', $pagination_str);
        if ($d != '') {
            $msg_flg = true;
        }
        $this->view->assign('msg_flg', $msg_flg);
    }

    /**
     * カレンダー型仕訳帳画面
     */
    public function calenderAction() {
        $output_date_select_html = '';

        // 家計簿データに該当する出力年月の連想配列を取得する
        $src_array = AccountingProc::generatedOutPutArray($this->login_user_obj->getId());

        // 家計簿データの出力年月はあるか
        if (! empty($src_array)) {
            // 出力年月のプルダウンを生成する
            $output_date_select_html = Util::arrayToSelect(array ('name' => 'outputDate', 'id' => 'js-calender',
                    'class' => 'ctl-select date-select'), $src_array, '');
        }

        // データ出力
        $this->view->assign('output_date_select_html', $output_date_select_html);
    }

    /**
     * カレンダー表示月変更
     */
    public function changeCalenderAction() {
        $post_item = $this->request->getPost();
        $search_date = (isset($post_item['search_date'])) ? Request::trimReqSpaceHerf($post_item['search_date']) : '';

        $result_search_date_flg = AccountingProc::isFormatCalenderDate($search_date);

        $result_data = array ('status' => 'error');

        if ($result_search_date_flg) {
            $calender_list = AccountingProc::getCalenderData($search_date, $this->login_user_obj->getId());
            $result_data = array ('status' => 'success', 'calender_list' => $calender_list);
        }

        echo json_encode($result_data);
        exit();
    }
    /**
     * 試算表画面
     */
    public function tbAction() {
        $get_item = $this->request->getQuery();
        $search_date = (isset($get_item['date'])) ? Request::trimReqSpaceHerf($get_item['date']) : '';

        $output_date_select_html = '';
        $tb_obj_list = null;

        // 出力年月の連想配列を取得する
        $src_array = AccountingProc::generatedOutPutArray($this->login_user_obj->getId());

        if (! empty($src_array)) {
            // 出力年月のプルダウンを生成する
            $output_date_select_html = Util::arrayToSelect(array ('name' => 'date', 'id' => 'js-closeing',
                    'class' => 'ctl-select date-select'), $src_array, $search_date);

            if ($search_date == '') {
                $search_date = current(array_slice($src_array, 0, 1, true));
            } else if (! AccountingProc::isFormatCalenderDate($search_date)) {
                Redirect::err500();
            }

            // 試算表データを取得する
            $tb_obj_list = AccountingProc::getTbData($search_date, $this->login_user_obj->getId());
        }

        // データ出力
        $this->view->assign('output_date_select_html', $output_date_select_html);
        $this->view->assign('tb_obj_list', $tb_obj_list);
        $this->view->assign('date', $search_date);
    }

    /**
     * 決算書画面
     */
    public function bs_plAction() {
        $query_item = $this->request->getQuery();
        $search_date = (isset($query_item['date'])) ? Request::trimReqSpaceHerf($query_item['date']) : '';

        $output_date_select_html = '';
        $bs_pl_obj_list = null;

        // 出力年月の連想配列を取得する
        $src_array = AccountingProc::generatedOutPutArray($this->login_user_obj->getId());

        if (! empty($src_array)) {
            // 出力年月のプルダウンを生成する
            $output_date_select_html = Util::arrayToSelect(array ('name' => 'date', 'id' => 'js-closeing',
                    'class' => 'ctl-select date-select'), $src_array, $search_date);

            if ($search_date == '') {
                $search_date = current(array_slice($src_array, 0, 1, true));
            } else if (! AccountingProc::isFormatCalenderDate($search_date)) {
                Redirect::err500();
            }

            // 決算データを取得する
            $bs_pl_obj_list = AccountingProc::getBsPlData($search_date, $this->login_user_obj->getId());
        }

        // データ出力
        $this->view->assign('output_date_select_html', $output_date_select_html);
        $this->view->assign('bs_pl_obj_list', $bs_pl_obj_list);
        $this->view->assign('date', $search_date);
    }

    // 家計簿削除
    public function deleteAction() {
        $query_item = $this->request->getQuery();
        $budget_id = (isset($query_item['budget_id'])) ? Request::trimReqSpaceHerf($query_item['budget_id']) : '';

        if (! is_numeric($budget_id)) {
            Redirect::err403();
        }

        $result_flg = AccountingProc::deleteBudget($budget_id);

        if (! $result_flg) {
            Redirect::err500();
        }
        header('Location: list?d=success');
        exit();
    }
}