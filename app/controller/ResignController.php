<?php
require_once 'com/MainController.php';
require_once dirname(__FILE__) . '/../../framework/Cookie.php';
require_once dirname(__FILE__) . '/../model/LoginProc.php';
class ResignController extends MainController {
    public function __construct() {
        parent::__construct();
    }

    public function preAction(){
        parent::preAction();
    }

    /**
     * 退会確認画面表示
     */
    public function indexAction() {
        if (! $this->session->has('login_user_obj')) {
            Redirect::locationTop();
        }

        if (ServerInfo::getReqMethod('GET')) {
            $this->session->setSession('sstoken', Security::generateToken());

            $this->view->assign('token', $this->session->getSession('sstoken'));
        }else{
            if (! Security::checkToken()) {
                Redirect::err403();
            }

            //ユーザーIDを取得する
            $user_detail_obj = unserialize($this->session->getSession('login_user_obj'));
            $user_id = intval($user_detail_obj->getId());

            //家計簿情報を削除する
            LoginProc::deleteBudget($user_id);

            //お問い合わせ情報を削除する
            LoginProc::deleteContact($user_id);

            // DB上に登録されているcookieを削除する
            LoginProc::deleteCookieByUserId($user_id);

            //cookieは設定されているか
            if (Cookie::isHasCookie(COOKIE_NAME)) {
                // ブラウザのcookieを削除する
                Cookie::destroy(COOKIE_NAME, COOKIE_EFFECT_PATH);

                //cookieを初期化
                if(Cookie::isHasCookie($this->session->getSessionName())){
                    Cookie::destroy($this->session->getSessionName(), COOKIE_EFFECT_PATH);
                }
            }
            //トランザクションを削除する
            LoginProc::deleteTransaction($user_id);

            //ユーザー情報を削除する
            LoginProc::deleteUser($user_id);

            //セッションを初期化する
            $this->session->clear();

            // セッションを破棄する
            $this->session->destroy();

            // 退会完了画面表示処理
            Redirect::locationComplete();
        }
    }

    /**
     * 退会完了画面
     */
    public function completeAction() {
        if(! ServerInfo::getReferer(SITE_URL . 'resign/')) {
            Redirect::locationTop();
        } else if ($this->session->has('login_user_obj')) {
            Redirect::locationHome();
        }
    }
}