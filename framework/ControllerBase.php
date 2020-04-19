<?php
require_once 'libs/smarty/Smarty.class.php';
require_once 'hidden/Request.php';
require_once 'hidden/Session.php';
require_once 'Security.php';
require_once 'ServerInfo.php';

abstract class ControllerBase {
    protected $systemRoot;
    protected $controller = 'index';
    protected $action = 'index';
    protected $view;
    protected $request;
    protected $session;
    protected $subSysRoot;

    // コンストラクタ
    public function __construct(){
        $this->request = new Request();

        // SESSIONパラメータはあるか
        $this->session = Session::getInstance();
    }

    // システムのルートディレクトリパスを設定
    public function setSystemRoot($path){
        $this->systemRoot = $path;
    }
    public function setSubSystemRoot($dir){
        $this->subSysRoot = $dir;
    }

    // コントローラーとアクションの文字列設定
    public function setControllerAction($controller, $action){
        $this->controller = $controller;
        $this->action = $action;
    }

    // 処理実行
    public function run(){
        try {
            // ビューの初期化
            $this->initializeView();

            // 共通前処理
            $this->preAction();

            // アクションメソッド
            $methodName = sprintf('%sAction', $this->action);

            //phpinfo();
            //call_user_func($methodName);

            $this->$methodName();

            // 表示
            $template_name = $this->controller . '/' . $this->action . '.tpl';
            $this->view->display(dirname(__FILE__) . '/../'. $this->subSysRoot .'/view/templates/'. $template_name);
        } catch (Exception $e) {
            // ログ出力等の処理を記述
        }
    }

    // ビューの初期化
    protected function initializeView(){
        $this->view = new Smarty();
        $this->view->setTemplateDir('view/templates');
        $this->view->setCompileDir('view/templates_c');
    }

    // 共通前処理（オーバーライド前提）
    protected function preAction(){}
}
