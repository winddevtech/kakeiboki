<?php
require_once dirname(__FILE__) . '/../../../framework/ControllerBase.php';
require_once dirname(__FILE__) . '/../../../app/config/config.php';
require_once dirname(__FILE__) . '/../../../app/model/Redirect.php';
require_once dirname(__FILE__) . '/../../model/LoginProc.php';
require_once dirname(__FILE__) . '/../../model/detail/AdminDetail.php';

abstract class MainController  extends ControllerBase {


    public function __construct(){
        parent::__construct();

        //リダイレクト用のURLパラメータを設定
        Redirect::setSiteUrl(SITE_URL_KANRI);
    }

    // 共通前処理（オーバーライド前提）
    protected function preAction(){
        //システムルート、css、jsのパス出力に用いる
        $this->view->assign('systemRoot', '/' . $this->systemRoot);
    }
}
