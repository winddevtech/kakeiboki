<?php
require_once 'com/MainController.php';
require_once dirname(__FILE__) . '/../model/HistoryProc.php';

//更新履歴コントローラー
class HistoryController extends MainController {
    public function __construct() {
        parent::__construct();
    }

    public function preAction(){
        if ($this->session->has('login_user_obj')) {
            Redirect::locationHome();
        }

        parent::preAction();
    }

    /**
     * 更新履歴表示
     */
    public function indexAction() {
        //更新履歴一覧
        $historyList = HistoryProc::getList();

        // バージョン履歴は取得できたか
        if (! $historyList) {
            Redirect::err500();
        }

        //更新履歴件数
        $totalPage = HistoryProc::getCount();

        // 更新履歴件数は取得できたか
        if (! $totalPage) {
            Redirect::err500();
        }

        //データ出力
        $this->view->assign('totalPage', $totalPage);
        $this->view->assign('historyList', $historyList);
    }
}