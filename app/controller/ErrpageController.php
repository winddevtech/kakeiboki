<?php
require_once 'com/MainController.php';

//エラーページコントローラー
class ErrpageController extends MainController {

    public function __construct() {
        parent::__construct();
    }

    public function preAction(){
        $login_flg = false;

        parent::preAction();

        if ($this->session->has('login_user_obj')) {
            $login_flg = true;
        }

        $this->view->assign('login_flg', $login_flg);
    }

    /**
     * 403（forbidden）
     */
    public function err403Action() {
    }

    /**
     * 404（not found）
     */
    public function err404Action() {
    }

    /**
     * 500（internal）
     */
    public function err500Action() {
    }
}