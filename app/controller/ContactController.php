<?php
require_once 'com/MainController.php';
require_once dirname(__FILE__) . '/../../framework/Util.php';
require_once dirname(__FILE__) . '/../../framework/StrProc.php';
require_once dirname(__FILE__) . '/../model/detail/Contact.php';
require_once dirname(__FILE__) . '/../model/com/Form.php';
require_once dirname(__FILE__) . '/../model/ContactProc.php';
class ContactController extends MainController  {
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
     * お問い合わせ一覧画面
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

        // GETデータを取得
        $get_item = $this->request->getQuery();
        $s = (isset($get_item['s'])) ? Request::trimReqSpaceHerf($get_item['s']) : '';
        $o = (isset($get_item['o'])) ? Request::trimReqSpaceHerf($get_item['o']) : 'asc';
        $page_num = (isset($get_item['page'])) ? Request::trimReqSpaceHerf($get_item['page']) : 1;

        //GETデータチェック
        $sort_safe = ContactProc::sortWhiteListUser($s);
        $order_safe = Pagenation::orderWhitelist($o);
        if (! is_numeric($page_num)){
            $page_num = 1;
        }
        $display_count_safe = ContactProc::displayCountWhiteList($this->login_user_obj->getDispCount());
        $display_count_safe = intval($display_count_safe);

        //1ページに表示する件数を設定する
        Pagenation::setPageCount($display_count_safe);

        //仕訳データを指定位置から指定件数分取得する
        $offset = Pagenation::calcOffset($page_num);
        $contact_obj_list = ContactProc::getList($this->login_user_obj->getId(), $sort_safe, $order_safe, $offset, $display_count_safe);
        $total = ContactProc::getCount($this->login_user_obj->getId());

        // 検索した仕訳データ件数を取得する
        $total_page = Pagenation::calcTotalPage($total);

        //ソートアイコンHTML文字列
        $arrow_icon = Pagenation::generateSortIcon($order_safe);

        //ページネーションHTML文字列
        $pagination_str = Pagenation::generatePagination($sort_safe, $order_safe, $page_num, $total_page);

        // ソート条件（並び順）を変更する
        $order_safe = Pagenation::changeOrder($o);

        //データ出力
        $this->view->assign('contact_obj_list', $contact_obj_list);
        $this->view->assign('sort_safe', $sort_safe);
        $this->view->assign('order_safe', $order_safe);
        $this->view->assign('arrow_icon', $arrow_icon);
        $this->view->assign('total_page', $total_page);
        $this->view->assign('offset', $offset);
        $this->view->assign('pagination_str', $pagination_str);
    }
    /**
     * お問い合わせ内容入力画面
     */
    public function indexAction() {
        $category_id = '';
        $context = '';
        $err_category_id = '';
        $err_context = '';

        $err_msg = array ();

        if (ServerInfo::getReqMethod('GET')) {
            $this->session->setSession('sstoken', Security::generateToken());

            // お問い合わせ内容登録情報セッションが残っているか
            if ($this->session->has('setting_contact_obj')) {
                // セッション内容を取得する
                $form_obj = unserialize($this->session->getSession('setting_contact_obj'));
                $contact_detail_obj = $form_obj->getDetailObj();
                $category_id = $contact_detail_obj->getCategoryId();
                $context = $contact_detail_obj->getContext();
                $err_msg = $form_obj->getErrMsg();
            }
        }else{
            if (! Security::checkToken()) {
                Redirect::err403();
            }

            // POSTデータを取得
            $post_item = $this->request->getPost();
            $category_id = Request::initReqSpaceHerf($post_item['category_id']);
            $context = Request::initReqSpaceHerf($post_item['context']);

            //詳細オブジェクトを作成
            $contact_detail_obj = new Contact();
            $contact_detail_obj->setUserId($this->login_user_obj->getId());
            $contact_detail_obj->setCategoryId($category_id);
            $contact_detail_obj->setContext($context);

            //フォームオブジェクトを作成
            $form_obj = new Form($contact_detail_obj);

            // 入力エラーチェック
            $form_obj = ContactProc::valid($form_obj);
            $err_msg = $form_obj->getErrMsg();

            //お問い合わせ情報セッションを設定
            $this->session->setSession('setting_contact_obj', serialize($form_obj));

            // エラーはなしか
            if (empty($err_msg)) {
                // 確認画面へ
                Redirect::locationConfirm();
            }
        }

        // エラーメッセージがあれば表示用のhtml文字列を生成する
        if (isset($err_msg['category_id'])) $err_category_id = Util::errMsgHtml($err_msg['category_id']);
        if (isset($err_msg['context'])) $err_context = Util::errMsgHtml($err_msg['context']);

        //カテゴリーを選択するプルダウンhtml文字列を生成する
        $category_id_html_str = ContactProc::createArrayToSelect($category_id);

        //データ出力
        $this->view->assign('token', $this->session->getSession('sstoken'));
        $this->view->assign('category_id_select', $category_id_html_str);
        $this->view->assign('context', Security::h($context));
        $this->view->assign('err_category_id', $err_category_id);
        $this->view->assign('err_context', $err_context);
    }

    /**
     * 入力内容確認画面
     */
    public function confirmAction() {
        if (! $this->session->has('setting_contact_obj')) {
            Redirect::locationHome();;
        }

        //入力情報セッションを取得
        $form_obj = unserialize($this->session->getSession('setting_contact_obj'));
        $contact_detail_obj = $form_obj->getDetailObj();
        $category_id = $contact_detail_obj->getCategoryId();
        $context = $contact_detail_obj->getContext();

        if (ServerInfo::getReqMethod('GET')){
            // 初回表示時
            if(! ServerInfo::getReferer(SITE_URL . 'contact/')) {
                Redirect::locationHome();
            }

            $this->session->setSession('sstoken', Security::generateToken());

            // 出力データの割り当て
            $this->view->assign('token', $this->session->getSession('sstoken'));
            $category_value = ContactProc::categoryWhiteList($category_id);
            $this->view->assign('category_value', $category_value);
            $this->view->assign('context', Security::h($context));
        }else{
            //登録ボタン押下時
            if (! Security::checkToken()) {
                Redirect::err403();
            }

            // お問い合わせ内容をDBに登録する
            $contact_detail_obj->setUserId($this->login_user_obj->getId());
            $isExecute = ContactProc::insertContact($contact_detail_obj);

             // DB登録に失敗したか
            if (! $isExecute) {
                Redirect::err500();
            }

            // お問い合わせデータが格納されているセッション変数を破棄
            $this->session->remove('setting_contact_obj');

            Redirect::locationComplete();
        }
    }
    /**
     * お問い合わせ内容DB登録処理
     */
    public function completeAction() {
        if(! ServerInfo::getReferer(SITE_URL . 'contact/confirm')) {
            Redirect::locationHome();
        }
    }


}