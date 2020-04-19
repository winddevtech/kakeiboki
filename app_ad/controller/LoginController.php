<?php
require_once 'com/MainController.php';
require_once dirname(__FILE__) . '/../../framework/Util.php';
require_once dirname(__FILE__) . '/../../app/model/com/Form.php';
class LoginController extends MainController {
    public function __construct() {
        parent::__construct();
    }

    public function preAction(){
        parent::preAction();
    }

    /**
     * ログイン画面
     */
    public function indexAction() {
        $login_id = '';
        $password = '';
        $err_login_id = '';
        $err_password = '';
        $err_msg = array ();

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            //ログイン画面表示
            if ($this->session->has('login_admin')) {
                Redirect::locationAdHome();
            }

            $this->session->setSession('sstoken', Security::generateToken());
        }else{
            //ログインボタン押下
            if (! Security::checkToken()) {
                Redirect::err403();
            }

            $post_item = $this->request->getPost();
            $login_id = isset($post_item['login_id']) ? trim(mb_convert_kana($post_item['login_id'], 's', 'UTF-8')) : '';
            $password = isset($post_item['password']) ? trim($post_item['password']) : '';

            //詳細オブジェクトを作成
            $admin_detail_obj = new AdminDetail();
            $admin_detail_obj->setLoginId($login_id);
            $admin_detail_obj->setPassword($password);

            //フォームオブジェクトを作成
            $form_obj = new Form($admin_detail_obj);

            // 入力エラーチェック
            $form_obj = LoginProc::valid($form_obj);
            $err_msg = $form_obj->getErrMsg();

            // ログインエラーはなしか
            if (empty($err_msg)) {
                $this->session->setSession('login_admin', 'login');
                $this->session->regenerateId();

                Redirect::locationAdHome();
            }
        }

        if (isset($err_msg['login_id'])) $err_login_id = Util::errMsgHtml($err_msg['login_id']);
        if (isset($err_msg['password'])) $err_password = Util::errMsgHtml($err_msg['password']);

        $this->view->assign('login_id', Security::h($login_id));
        $this->view->assign('password', Security::h($password));
        $this->view->assign('err_login_id', $err_login_id);
        $this->view->assign('err_password', $err_password);
        $this->view->assign('token', $this->session->getSession('sstoken'));
    }

    /**
     * ログアウト処理
     */
    public function logoutAction() {
        if (! $this->session->has('login_admin')) {
            Redirect::locationAdHome();
        }

        $this->session->clear();
        $this->session->destroy();
        Redirect::locationTop();
    }
}