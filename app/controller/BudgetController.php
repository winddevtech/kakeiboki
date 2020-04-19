<?php
require_once 'com/MainController.php';
require_once dirname(__FILE__) . '/../model/detail/Budget.php';
require_once dirname(__FILE__) . '/../../framework/StrProc.php';
require_once dirname(__FILE__) . '/../model/com/Form.php';
require_once dirname(__FILE__) . '/../model/BudgetProc.php';
class BudgetController extends MainController {
    public function __construct() {
        parent::__construct();
    }

    public function preAction(){
        if (! $this->session->has('login_user_obj')) {
            Redirect::locationTop();
        }
        parent::preAction();
    }

    /**
     * 家計簿データ設定フォーム画面
     */
    public function indexAction() {
        $creation_date = '';
        $use_item_id = '';
        $price = '';
        $summary = '';
        $budget_id_safe = '';
        $err_creation_date = '';
        $err_use_item_id = '';
        $err_price = '';
        $err_summary = '';

        $err_msg = array();

        if (ServerInfo::getReqMethod('GET')){
            //初回表示時

            $this->session->setSession('sstoken', Security::generateToken());

            //家計簿IDを取得
            $get_item = $this->request->getQuery();
            $budget_id = Request::trimReqSpaceHerf($get_item['budget_id']);

            //家計簿IDは数値か
            if (is_numeric($budget_id)) {
                //家計簿データを取得
                $search_obj = BudgetProc::searchBudget($budget_id);
                if (is_object($search_obj)) {
                    $budget_id_safe = $search_obj->getid();
                    $creation_date = $search_obj->getCreationDate();
                    $use_item_id = $search_obj->getUseItem();
                    $price = $search_obj->getPrice();
                    $summary = $search_obj->getSummary();
                    $form_obj = new Form($search_obj);
                    $this->session->setSession('setting_budget_obj', serialize($form_obj));
                }
            }else if ($this->session->has('setting_budget_obj')) {
                // 家計簿情報セッションが残っていた場合、セッション内容を取得
                $form_obj = unserialize($this->session->getSession('setting_budget_obj'));
                $budget_detail_obj = $form_obj->getDetailObj();
                $creation_date = $budget_detail_obj->getCreationDate();
                $use_item_id = $budget_detail_obj->getUseItem();
                $price = $budget_detail_obj->getPrice();
                $summary = $budget_detail_obj->getSummary();
                $err_msg = $form_obj->getErrMsg();
            }
        } else {
            //確認ボタン押下時
            if (! Security::checkToken()) {
                Redirect::err403();
            }

            // POSTデータを取得
            $post_item = $this->request->getPost();
            if (isset($post_item['budget_id'])) {
                $budget_id = Request::trimReqSpaceHerf($post_item['budget_id']);
            }
            $creation_date = Request::trimReqSpaceHerf($post_item['creation_date']);
            $use_item_id = Request::trimReqSpaceHerf($post_item['use_item_id']);
            $price = Request::trimReqSpaceHerf($post_item['price']);
            $summary = Request::trimReqSpaceHerf($post_item['summary']);

            //詳細オブジェクトを作成
            if ($this->session->has('setting_budget_obj')) {
                $form_obj = unserialize($this->session->getSession('setting_budget_obj'));
                $budget_detail_obj = $form_obj->getDetailObj();
            } else {
                $budget_detail_obj = new Budget();
            }

            $budget_detail_obj->setCreationDate($creation_date);
            $budget_detail_obj->setUseItem($use_item_id);
            $budget_detail_obj->setPrice($price);
            $budget_detail_obj->setSummary($summary);

            //フォームオブジェクトを作成
            $form_obj = new Form($budget_detail_obj);

            // 入力エラーチェック
            $form_obj = BudgetProc::valid($form_obj);
            $err_msg = $form_obj->getErrMsg();

            //家計簿情報セッションを設定
            $this->session->setSession('setting_budget_obj', serialize($form_obj));

            // エラーはなしか
            if (empty($err_msg)) {
                // 確認画面へ
                Redirect::locationConfirm();
            }
        }

        // エラーメッセージがあれば表示用のhtml文字列を生成する
        require_once dirname(__FILE__) . '/../../framework/Util.php';
        if (isset($err_msg['creation_date'])) $err_creation_date = Util::errMsgHtml($err_msg['creation_date']);
        if (isset($err_msg['use_item_id'])) $err_use_item_id = Util::errMsgHtml($err_msg['use_item_id']);
        if (isset($err_msg['price'])) $err_price = Util::errMsgHtml($err_msg['price']);
        if (isset($err_msg['summary'])) $err_summary = Util::errMsgHtml($err_msg['summary']);

        //用途選択のプルダウンhtml文字列を生成する
        $use_item_select_html = BudgetProc::createArrayToSelect($use_item_id);

        //データ出力
        $this->view->assign('token', $this->session->getSession('sstoken'));
        $this->view->assign('creation_date', Security::h($creation_date));
        $this->view->assign('use_item_select_html', $use_item_select_html);
        $this->view->assign('price', Security::h($price));
        $this->view->assign('summary', Security::h($summary));
        $this->view->assign('budget_id', $budget_id_safe);
        $this->view->assign('err_creation_date', $err_creation_date);
        $this->view->assign('err_use_item_id', $err_use_item_id);
        $this->view->assign('err_price', $err_price);
        $this->view->assign('err_summary', $err_summary);
    }

    /**
     * 入力内容確認画面
     */
    public function confirmAction() {
        $edit_mode = '登録';

        if (! $this->session->has('setting_budget_obj')) {
            Redirect::locationHome();;
        }

        //家計簿情報セッションを取得
        $form_obj = unserialize($this->session->getSession('setting_budget_obj'));
        $budget_detail_obj = $form_obj->getDetailObj();
        $budget_id = $budget_detail_obj->getId();
        $creation_date = $budget_detail_obj->getCreationDate();
        $use_item_id = $budget_detail_obj->getUseItem();
        $price = $budget_detail_obj->getPrice();
        $summary = $budget_detail_obj->getSummary();

        if (ServerInfo::getReqMethod('GET')){
            /*if(! ServerInfo::getReferer(SITE_URL . 'budget/')) {
                Redirect::locationHome();
            }*/

             // 初回表示時
            $this->session->setSession('sstoken', Security::generateToken());

            // 家計簿データIDはあるか
            if ($budget_id) {
                $edit_mode = '変更';
            }

            //用途名を取得する
            $use_item_name = BudgetProc::useIdWhiteList($use_item_id);

            //仕訳結果データを取得する
            $search_result = BudgetProc::getJournalInfo($use_item_id);
            $debit_name = BudgetProc::journalIdWhiteList($search_result['debit_id']);
            $credit_name = BudgetProc::journalIdWhiteList($search_result['credit_id']);

            //出力データ
            $this->view->assign('token', $this->session->getSession('sstoken'));
            $this->view->assign('creation_date', Security::h($creation_date));
            $this->view->assign('use_item_name', $use_item_name);
            $this->view->assign('price', Security::h($price));
            $this->view->assign('summary', Security::h($summary));
            $this->view->assign('debit_name', $debit_name);
            $this->view->assign('credit_name', $credit_name);
            $this->view->assign('edit_mode', $edit_mode);
        } else {
            //登録・変更ボタン押下時
            if (! Security::checkToken()) {
                Redirect::err403();
            }

            $budget_id = intval($budget_id);

            // DBに設定する
            $budget_detail_obj->setUserId($this->login_user_obj->getId());
            // 家計簿データIDの有無で家計簿データの新規登録・更新を切り替える
            if ($budget_id) {
                $isExecute = BudgetProc::updateBudegt($budget_detail_obj);
                $edit_mode = '変更';
            } else {
                $isExecute = BudgetProc::insertBudget($budget_detail_obj);
            }

            // DB登録に失敗したか
            if (! $isExecute) {
                Redirect::err500();
            }

            BudgetProc::transaction($this->login_user_obj->getId(), '家計簿情報'. $edit_mode);

            // 家計簿データが格納されているセッション変数を破棄
            $this->session->remove('setting_budget_obj');

            Redirect::locationComplete();
        }
    }

    /**
     * 設定完了画面
     */
    public function completeAction() {
        if(! ServerInfo::getReferer(SITE_URL . 'budget/confirm')) {
            Redirect::locationHome();
        }
    }
}