<?php
require_once 'com/MainController.php';
require_once dirname(__FILE__) . '/../../framework/StrProc.php';
require_once dirname(__FILE__) . '/../../framework/Util.php';
require_once dirname(__FILE__) . '/../model/Mail.php';
require_once dirname(__FILE__) . '/../model/com/Form.php';
require_once dirname(__FILE__) . '/../model/EditProc.php';
class EditController extends MainController {
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
     * ユーザー情報変更画面
     */
    public function indexAction() {
        $user_name = '';
        $email = '';
        $display_count = '';
        $post_icon_img = '';
        $icon_img = '';
        $err_username = '';
        $err_email = '';
        $err_password = '';
        $err_password_conf = '';
        $err_display_count = '';
        $err_icon_img = '';
        $err_msg = array ();

        if (ServerInfo::getReqMethod('GET')) {
            //初回表示時
            $this->session->setSession('sstoken', Security::generateToken());

            //入力情報セッションを取得
            if ($this->session->has('setting_user_obj')) {
                //セッション内容を取得
                $form_obj = unserialize($this->session->getSession('setting_user_obj'));
                $user_detail_obj = $form_obj->getDetailObj();
                $user_name = $user_detail_obj->getName();
                $email = $user_detail_obj->getEmail();
                $display_count = $user_detail_obj->getDispCount();
                $icon_img = $user_detail_obj->getIconImg();
                $post_icon_img = $user_detail_obj->getIconImg();
                $err_msg = $form_obj->getErrMsg();
            } else {
                $user_detail_obj = $this->login_user_obj;
                $user_name = $user_detail_obj->getName();
                $email = $user_detail_obj->getEmail();
                $display_count = $user_detail_obj->getDispCount();
                $icon_img = $user_detail_obj->getIconImg();
                $post_icon_img = $user_detail_obj->getIconImg();
            }
        }else{
            //確認ボタン押下時
            if (! Security::checkToken()) {
                Redirect::err403();
            }

            // POSTデータを取得
            $post_item = $this->request->getPost();
            $user_name = Request::trimReqSpaceHerf($post_item['user_name']);
            $email = Request::trimReqSpaceHerf($post_item['email']);
            $password = trim($post_item['password']);
            $password_conf = trim($post_item['password_conf']);
            $display_count = trim($post_item['display_count']);
            $post_icon_img = trim($post_item['icon_img']);

            //詳細オブジェクトを作成
            $user_detail_obj = new User();
            $user_detail_obj->setName($user_name);
            $user_detail_obj->setEmail($email);
            $user_detail_obj->setPassword($password);
            $user_detail_obj->setDispCount($display_count);
            $user_detail_obj->setIconImg($post_icon_img);

            //フォームオブジェクトを作成
            $form_obj = new Form($user_detail_obj);
            $form_obj->addParam('password_conf', $password_conf);
            $login_user_obj = $this->login_user_obj;
            $form_obj->addParam('current_login_email', $login_user_obj->getEmail());

            // 入力エラーチェック
            $form_obj = EditProc::valid($form_obj);
            $err_msg = $form_obj->getErrMsg();

            $this->session->setSession('setting_user_obj', serialize($form_obj));

            // エラーはなしか
            if (empty($err_msg)) {
                // 確認画面へ
                Redirect::locationConfirm();
            }
        }

        // エラーメッセージがあれば表示用のhtml文字列を生成する
        if (isset($err_msg['user_name'])) $err_username = Util::errMsgHtml($err_msg['user_name']);
        if (isset($err_msg['email'])) $err_email = Util::errMsgHtml($err_msg['email']);
        if (isset($err_msg['password'])) $err_password = Util::errMsgHtml($err_msg['password']);
        if (isset($err_msg['password_conf'])) $err_password_conf = Util::errMsgHtml($err_msg['password_conf']);
        if (isset($err_msg['display_count'])) $err_display_count = Util::errMsgHtml($err_msg['display_count']);
        if (isset($err_msg['icon_img'])) $err_icon_img = Util::errMsgHtml($err_msg['icon_img']);

        //表示件数を選択するプルダウンhtml文字列を生成する
        $select_html_str = EditProc::createArrayToSelect($display_count);

        //アイコンが設定されていなければ初期アイコンを表示する
        $icon_img = EditProc::getDisplayIcon($post_icon_img);

        //データ出力
        $this->view->assign('token', $this->session->getSession('sstoken'));
        $this->view->assign('user_name', Security::h($user_name));
        $this->view->assign('email', Security::h($email));
        $this->view->assign('selectHtml', $select_html_str);
        $this->view->assign('post_icon_img', Security::h($post_icon_img));
        $this->view->assign('icon_img', Security::h($icon_img));
        $this->view->assign('err_username', $err_username);
        $this->view->assign('err_email', $err_email);
        $this->view->assign('err_password', $err_password);
        $this->view->assign('err_password_conf', $err_password_conf);
        $this->view->assign('err_display_count', $err_display_count);
        $this->view->assign('err_icon_img', $err_icon_img);
    }

    /**
     * 入力内容確認画面
     */
    public function confirmAction() {
        if (! $this->session->has('setting_user_obj')) {
            Redirect::locationHome();;
        }

        //入力情報セッションを取得
        $form_obj = unserialize($this->session->getSession('setting_user_obj'));
        $user_detail_obj = $form_obj->getDetailObj();
        $user_name = $user_detail_obj->getName();
        $email = $user_detail_obj->getEmail();
        $password = $user_detail_obj->getPassword();
        $display_count = $user_detail_obj->getDispCount();
        $icon_img = $user_detail_obj->getIconImg();

        if (ServerInfo::getReqMethod('GET')){
            // 初回表示時
            if(! ServerInfo::getReferer(SITE_URL . 'edit/')) {
                Redirect::locationHome();
            }

            $this->session->setSession('sstoken', Security::generateToken());

            // パスワードを*として画面に表示させる
            $password = StrProc::confirmPassword($password);

            //表示件数を取得する
            $display_count = EditProc::displayCountWhiteList($display_count);

            //アイコンが設定されていなければ初期アイコンを表示する
            $icon_img = EditProc::getDisplayIcon($icon_img);

            //出力データ
            $this->view->assign('token', $this->session->getSession('sstoken'));
            $this->view->assign('user_name', Security::h($user_name));
            $this->view->assign('email', Security::h($email));
            $this->view->assign('password', $password);
            $this->view->assign('display_count', $display_count);
            $this->view->assign('icon_img', Security::h($icon_img));
        }else{
            //変更ボタン押下時
            if (! Security::checkToken()) {
                Redirect::err403();
            }

            $login_user_obj = $this->login_user_obj;

            // ユーザー情報を更新する
            $user_detail_obj->setId($login_user_obj->getId());
            $isExecute = EditProc::updateUser($user_detail_obj);

            // DB更新に失敗したか
            if (! $isExecute) {
                Redirect::err500();
            }

            //ログインユーザー情報再設定
            $this->session->setSession('login_user_obj', serialize($user_detail_obj));

            EditProc::transaction($user_detail_obj->getId(),  'ユーザー情報変更');

            // ユーザーにメール通知する
            Mail::edit($email, $user_name);

            // ユーザー情報が格納されているセッション変数を破棄
            $this->session->remove('setting_user_obj');

            //変更完了画面へ
            Redirect::locationComplete();
        }
    }
    /**
     * 変更完了画面
     */
    public function completeAction() {
        if(! ServerInfo::getReferer(SITE_URL . 'edit/confirm')) {
            Redirect::locationHome();
        }
    }
}