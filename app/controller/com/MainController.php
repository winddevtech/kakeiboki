<?php
require_once dirname(__FILE__) . '/../../../framework/ControllerBase.php';
//require_once dirname(__FILE__) . '/../../config/config.php';
require_once dirname(__FILE__) . '/../../model/detail/User.php';
require_once dirname(__FILE__) . '/../../model/Redirect.php';

abstract class MainController  extends ControllerBase {
    protected $login_user_obj;

    public function __construct(){
        parent::__construct();

        //リダイレクト用のURLパラメータを設定
        Redirect::setSiteUrl(SITE_URL);
    }

    // 共通前処理（オーバーライド前提）
    protected function preAction(){
        //フォームセッション情報を削除
        $session_names = array();

        if ($this->controller != 'signup' && $this->controller != 'edit') {
            $session_names[] = 'setting_user_obj';
        }
        if ($this->controller != 'budget') {
            $session_names[] = 'setting_budget_obj';
        }
        if ($this->controller != 'import') {
            $session_names[] = 'setting_import_obj';
        }
        if ($this->controller != 'contact') {
            $session_names[] = 'setting_contact_obj';
        }
        if ($this->controller != 'auth') {
            $session_names[] = 'auth_user_obj';
        }
        foreach ($session_names as $session_name) {
            if ($this->session->has($session_name)) {
                $this->session->remove($session_name);
                break;
            }
        }

        //ログイン中か
        if ($this->session->has('login_user_obj')){
            require_once dirname(__FILE__) . '/../../../framework/StrProc.php';
            require_once dirname(__FILE__) . '/../../model/LoginProc.php';

            //ログイン情報オブジェクトを設定
            $this->login_user_obj = unserialize($this->session->getSession('login_user_obj'));

            //ユーザ名を設定
            $this->view->assign('login_user_name', Security::h($this->login_user_obj->getName()));

            //最終ログイン情報を設定（2重ログイン対策）
            $regist_time = StrProc::getTimeStampStr();
            LoginProc::updateUserSession($this->login_user_obj->getId(), $this->session->getSessionId(), $regist_time);
            $login_user_obj = $this->login_user_obj;
            $login_user_obj->setSessionId($this->session->getSessionId());
            $login_user_obj->setLastloginAt($regist_time);
            $this->session->setSession('login_user_obj', serialize($login_user_obj));
            $this->login_user_obj = $login_user_obj;
        }

        //システムルート、css、jsのパス出力に用いる
        $this->view->assign('systemRoot', '/' . $this->systemRoot);
    }
}
