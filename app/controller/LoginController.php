<?php
require_once 'com/MainController.php';
require_once dirname(__FILE__) . '/../../framework/Cookie.php';
require_once dirname(__FILE__) . '/../../framework/Util.php';
require_once dirname(__FILE__) . '/../model/com/Form.php';
require_once dirname(__FILE__) . '/../model/LoginProc.php';
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
        $user_name = '';
        $email = '';
        $auto_login_flg = '';
        $err_email = '';
        $err_password = '';
        $err_multiple = '';
        $err_msg = array ();

        if (ServerInfo::getReqMethod('GET')) {
            //初回アクセス時

            // ログイン情報セッションが残っているか
            if ($this->session->has('login_user_obj')) {
                Redirect::locationHome();
            } else if (Cookie::isHasCookie(COOKIE_NAME)) {
                // Cookieがセットされている場合
                // DBにあるCookieがあれば自動ログインする
                $auto_login_key = Cookie::getAutoLoginKey(COOKIE_NAME);

                $result = LoginProc::getCookieInDB($auto_login_key);

                // DBに該当Cookieはあるか
                if ($result) {
                    // Cookieが有効期間内なので自動ログイン設定する
                    $user = LoginProc::getUserbyUserId($result['user_id']);

                    $this->session->regenerateId(); // セッションハイジャック対策

                    //オブジェクト設定
                    $user_detail_obj = new User();
                    $user_detail_obj = LoginProc::createLoginObject($user_detail_obj, $user);

                    $this->session->setSession('login_user_obj', serialize($user_detail_obj));

                    Redirect::locationHome();
                }
            }

            //ログイン画面表示
            $this->session->setSession('sstoken', Security::generateToken());
        }else{
            //ログインボタン押下
            if (! Security::checkToken()) {
                Redirect::err500();
            }

            $post_item = $this->request->getPost();
            $email = Request::trimReqSpaceHerf($post_item['email']);
            $password = trim($post_item['password']);
            if (isset($post_item['auto_login'])) $auto_login_flg = trim($post_item['auto_login']);

            //詳細オブジェクトを作成
            $user_detail_obj = new User();
            $user_detail_obj->setEmail($email);
            $user_detail_obj->setPassword($password);

            //フォームオブジェクトを作成
            $form_obj = new Form($user_detail_obj);

            // エラーチェック
            $form_obj = LoginProc::valid($form_obj);
            $err_msg = $form_obj->getErrMsg();
            if (empty($err_msg)) {
                //ログイン処理

                // 古いCookie情報を削除
                LoginProc::deleteOldCookie();

                // 「自動でログイン」にチェックが入っているか
                if ($auto_login_flg) {
                    // cookieを新規登録する
                    LoginProc::autoLoginProc($user_detail_obj->getId(), $auto_login_flg);
                }

                $this->session->regenerateId();// セッションIDを書き換える(セッションハイジャック対策)

                // ログイン処理
                $this->session->setSession('login_user_obj', serialize($user_detail_obj));

                // ホーム画面へ
                Redirect::locationHome();
                //exit();
            }

            if (isset($err_msg['email'])) $err_email = Util::errMsgHtml($err_msg['email']);
            if (isset($err_msg['password'])) $err_password = Util::errMsgHtml($err_msg['password']);
            if (isset($err_msg['multiple'])) $err_multiple = Util::errMsgHtml($err_msg['multiple']);
        }

        $this->view->assign('email', Security::h($email));
        $this->view->assign('err_email', $err_email);
        $this->view->assign('err_password', $err_password);
        $this->view->assign('err_multiple', $err_multiple);
        $this->view->assign('token', $this->session->getSession('sstoken'));
    }

    /**
     * ログアウト処理
     */
    public function logoutAction() {
        if (! $this->session->has('login_user_obj')) {
            Redirect::locationTop();
        }

        // 最終ログイン日時とセッションIDを削除する
        $login_user_obj = unserialize($this->session->getSession('login_user_obj'));
        LoginProc::updateUserSession($login_user_obj->getId());

        // Cookie情報を削除
        LoginProc::deleteLogoutCookie($this->session->getSessionName());

        // セッションを初期化する
        $this->session->clear();

        // セッションを破棄する
        $this->session->destroy();

        // indexコントローラーのindexActionを実行
        Redirect::locationTop();
    }



}