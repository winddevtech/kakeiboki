<?php
class Dispatcher {
    private $sysRoot;
    private $error404Url;
    private $rootDirName;

    /**
     * システムのルートディレクトリを設定
     */
    public function setSystemRoot($path){
        $this->sysRoot = rtrim(ltrim($path, '/'), '/');
    }

    /**
     * ページが見つからなかった場合のURLを設定
     */
    public function setError404Url($error404Url){
        $this->error404Url = $error404Url;
    }

    /**
     * ルートディレクトリの指定
     */
    public function setRootDirName($rootDirName){
        $this->rootDirName = $rootDirName;
    }

    /**
     * 振分け処理実行
     */
    public function dispatch(){
        $param = '';
        $params = array();
        $controller = '';
        $action = 'index';
        $subSystemRoot = '';

        // URLからシステムルートを取り除く
        $param = substr($_SERVER['REQUEST_URI'], strlen('/'. $this->sysRoot.'/'));

        //URLにパラメータ開始文字「?」はついているか
        if (strpos($param, '?')) {
            $param = strstr($param, '?', true);
        }

        //「/」で分割
        $params = explode('/', $param);

        //「/」で分割した結果2つめの要素は空文字か
        if (isset($params[1]) && $params[1] == ''){
            $params[1] = 'index';
        }

        // １番目のパラメーターをコントローラーとして取得
        if (isset($params[0]) && $params[0] != '') {
            $controller = $params[0];
        }

        $sysRootStr = explode('/', $this->sysRoot);
        $subSystemRoot = $sysRootStr[1];

        //URLにディレクトリは未指定か
        if ($controller == '') {
            $controller = $this->rootDirName;
        }

        // １番目のパラメーターをもとにコントローラークラスインスタンス取得
        $controllerInstance = $this->getControllerInstance($controller, $subSystemRoot);
        if (null == $controller) {
            unset($controllerInstance);
            header('Location: '. $this->error404Url);
            exit();
        }

        // 2番目のパラメーターをアクションとして取得
        if (isset($params[1]) && $params[1] != '') {
            $action = $params[1];
        }

        // アクションメソッドの存在確認
        if (! method_exists($controllerInstance, $action . 'Action')) {
            unset($controllerInstance);
            header('Location: '. $this->error404Url);
            exit();
        }

        // コントローラー初期設定
        $controllerInstance->setSystemRoot($this->sysRoot);
        $controllerInstance->setSubSystemRoot($subSystemRoot);
        $controllerInstance->setControllerAction($controller, $action);

        // 処理実行
        $controllerInstance->run();
    }

    // コントローラークラスのインスタンスを取得
    private function getControllerInstance($controller, $subSystemRoot){
        // 一文字目のみ大文字に変換＋'Controller'
        $className = ucfirst(strtolower($controller)) . 'Controller';

        // コントローラーファイル名
        $controllerFileName = sprintf('/../'. $subSystemRoot .'/controller/%s.php',  $className);

        // ファイル存在チェック
        if (!  file_exists(dirname(__FILE__) . $controllerFileName)) {
            return null;
        }
        // クラスファイルを読込
        require_once dirname(__FILE__) . $controllerFileName;
        // クラスが定義されているかチェック
        if (! class_exists($className)) {
            return null;
        }
        // クラスインスタンス生成
        $controllerInstarnce = new $className();

        return $controllerInstarnce;
    }
}
