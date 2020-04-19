<?php
require_once 'com/MainController.php';
require_once dirname(__FILE__) . '/../model/ReplyProc.php';
require_once dirname(__FILE__) . '/../../app/model/Redirect.php';

class ReplyController extends MainController {
    public function __construct() {
        parent::__construct();
    }

    public function preAction(){
        if (! $this->session->has('login_admin')) {
            Redirect::locationTop();
        }
        parent::preAction();
    }

    /**
     * 一覧画面
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
        $search_param = '';

        // GETデータを取得
        $get_item = $this->request->getQuery();
        $search_param = (isset($get_item['p'])) ? Request::trimReqSpaceHerf($get_item['p']) : '';
        $s = (isset($get_item['s'])) ? Request::trimReqSpaceHerf($get_item['s']) : '';
        $o = (isset($get_item['o'])) ? Request::trimReqSpaceHerf($get_item['o']) :'asc';
        $page_num = (isset($get_item['page'])) ? Request::trimReqSpaceHerf($get_item['page']) : 1;

        //GETデータチェック
        $sort_safe = ReplyProc::sortWhiteListAd($s);
        $order_safe = Pagenation::orderWhitelist($o);
        if (! is_numeric($page_num)){
            $page_num = 1;
        }

        //1ページに表示する件数を設定する
        Pagenation::setPageCount(10);

        //返信リストを指定位置から指定件数分取得する
        $offset = Pagenation::calcOffset($page_num);
        $reply_obj_list = ReplyProc::getReplyListByKeyword($search_param, $sort_safe, $order_safe, $offset);
        $total = ReplyProc::getReplyListCountByKeyword($search_param);

        // 検索した返信リスト件数を取得する
        $total_page = Pagenation::calcTotalPage($total);

        //ソートアイコンHTML文字列
        $arrow_icon = Pagenation::generateSortIcon($order_safe);

        $search_param_array = array('p', $search_param);
        //ページネーションHTML文字列
        $pagination_str = Pagenation::generatePagination($sort_safe, $order_safe, $page_num, $total_page, $search_param_array);

        // ソート条件（並び順）を変更する
        $order_safe = Pagenation::changeOrder($o);

        //データ出力
        $this->view->assign('reply_obj_list', $reply_obj_list);
        $this->view->assign('p', Security::h($search_param));
        $this->view->assign('sort_safe', $sort_safe);
        $this->view->assign('order_safe', $order_safe);
        $this->view->assign('arrow_icon', $arrow_icon);
        $this->view->assign('total_page', $total_page);
        $this->view->assign('offset', $offset);
        $this->view->assign('pagination_str', $pagination_str);
    }


}