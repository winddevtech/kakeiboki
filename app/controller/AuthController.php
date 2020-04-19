<?php
require_once 'com/MainController.php';
require_once dirname(__FILE__) . '/../../framework/Util.php';
require_once dirname(__FILE__) . '/../model/Mail.php';
require_once dirname(__FILE__) . '/../model/com/Form.php';
require_once dirname(__FILE__) . '/../model/AuthProc.php';
require_once dirname(__FILE__) . '/../model/detail/User.php';
class AuthController extends MainController {
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
     * 仮パスワード発行申請画面
     */
    public function indexAction() {
        $email = '';
        $err_email = '';
        $err_msg = array();

        if (ServerInfo::getReqMethod('GET')) {
            $this->session->setSession('sstoken', Security::generateToken());

            // 認証情報セッションが残っているか
            if ($this->session->has('auth_user_obj')) {
                //セッション内容を取得する
                $form_obj = unserialize($this->session->getSession('auth_user_obj'));
                $user_detail_obj = $form_obj->getDetailObj();
                $email = $user_detail_obj->getEmail();
                $err_msg = $form_obj->getErrMsg();
            }
        }else{
            if (! Security::checkToken()) {
                Redirect::err403();
            }

            $email = Request::trimReqSpaceHerf($this->request->getPost('email'));

            //詳細オブジェクトを作成
            $user_detail_obj = new User();
            $user_detail_obj->setEmail($email);

            //フォームオブジェクトを作成
            $form_obj = new Form($user_detail_obj);

            // 入力エラーチェック
            $form_obj = AuthProc::valid($form_obj);
            $err_msg = $form_obj->getErrMsg();

            //認証情報セッションを設定
            $this->session->setSession('auth_user_obj', serialize($form_obj));

            //エラーメッセージはなしか
            if (empty($err_msg)) {
                //仮パスワードを生成してDBに登録する
                $isExecute = AuthProc::updateUser($user_detail_obj);

                // DB登録に失敗したか
                if (! $isExecute) {
                    Redirect::err500();
                }

                //仮パスワードが登録されたユーザー情報を取得する
                $user_row = AuthProc::select($user_detail_obj);

                //ユーザ情報取得に失敗したか
                if (! $user_row) {
                    Redirect::err500();
                }

                //仮パスワードをユーザーにメール通知する
                Mail::auth($email, $user_row['name'], $kari_password);

                // ユーザー情報が格納されているセッション変数を破棄
                $this->session->remove('auth_user_obj');

                // 認証画面表示処理
                Redirect::locationComplete();
            }
        }

        // エラーはあるか
        if (isset($err_msg['email'])) $err_email = Util::errMsgHtml($err_msg['email']);

        //出力データ
        $this->view->assign('token', $this->session->getSession('sstoken'));
        $this->view->assign('email', Security::h($email));
        $this->view->assign('err_email', $err_email);
    }


    /**
     * ユーザー情報DB登録処理
     */
    public function completeAction() {
        if(! ServerInfo::getReferer(SITE_URL . 'auth/')) {
            Redirect::locationTop();
        }
    }
}