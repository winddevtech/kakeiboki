<?php


//DB管理クラス
class DBManager {
    private $className; //実行する処理

    public function __construct($actionName) {
        $this->className = $actionName;
    }

    public function insert($className, $dataObj) {
        //バリデーション対象のファイルを読み込み
        $result_flg = self::isReadVaildFile($className);
        if (!$result_flg) {
            exit;
        }

        $isExecute = $className::insert($dataObj);

        return $isExecute ? true : false;
    }

    public static function update($dataObj) {
        //バリデーション対象のファイルを読み込み
        $result_flg = self::isReadVaildFile($this->className);
        if (!$result_flg) {
            exit;
        }

        $isExecute = $this->className::update($dataObj);

        return $isExecute ? true : false;
    }

    public static function delete($className, $formObj) {
        //バリデーション対象のファイルを読み込み
        $result_flg = self::isReadVaildFile($className);
        if (!$result_flg) {
            exit;
        }

        //バリデーション実行
        $className::delete($formObj);

        return $formObj;
    }

    public function select($className, $dataObj) {
        //バリデーション対象のファイルを読み込み
        $result_flg = self::isReadVaildFile($className);
        if (!$result_flg) {
            exit;
        }

        //検索実行
        $result_data = $className::select($dataObj);

        return $result_data;
    }

    public function transaction($userId, $actionName) {
        require_once 'db/Transaction.php';

        $isExecute = TransactionDB::insert($userId, $actionName);

        return $isExecute ? true : false;
    }

    public function getCount($className, $formObj) {
        //バリデーション対象のファイルを読み込み
        $result_flg = self::isReadVaildFile($className);
        if (!$result_flg) {
            exit;
        }

        //バリデーション実行
        $className::select($formObj);

        return $formObj;
    }


    // コントローラークラスのインスタンスを取得
    private static function isReadVaildFile($className){
        // 一文字目のみ大文字に変換＋'Controller'
        //$className = ucfirst(strtolower($controller)) . 'Controller';

        // コントローラーファイル名
        $vaildClsFileName = sprintf('%s.php',  $className);

        // ファイル存在チェック
        if (!  file_exists(dirname(__FILE__) . $vaildClsFileName)) {
            return false;
        }
        // クラスファイルを読込
        require_once dirname(__FILE__) . $vaildClsFileName;
        // クラスが定義されているかチェック
        if (! class_exists($className)) {
            return false;
        }

        return true;
    }
}