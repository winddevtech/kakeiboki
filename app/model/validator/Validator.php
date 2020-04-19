<?php
require_once dirname(__FILE__) . '/../../../framework/Validation.php';
require_once dirname(__FILE__) . '/../const/InputConst.php';
//バリデータークラス
class Validator {

    //バリデーション実行
    public static function valid($className, $formObj) {
        if (! self::isValidFile($className)){
            exit();
        }

        //バリデーション実行
        $methodName = 'valid';
        $formObj = $className::$methodName($formObj);

        return $formObj;
    }

    //DB検索バリデーション実行
    public static function validSearchError($className, $formObj) {
        $methodName = 'setValidSearchError';
        return $className::$methodName($formObj);
    }

    //バリデーション対象のファイルを読み込み
    private static function isValidFile($className){
        $isExist = self::isReadVaildFile($className);

        if (! $isExist) {
            return false;
        }

        return true;
    }


    // コントローラークラスのインスタンスを取得
    private static function isReadVaildFile($className){
        // 一文字目のみ大文字に変換＋'Controller'
        //$className = ucfirst(strtolower($className));

        // コントローラーファイル名
        $vaildClsFileName = sprintf('/%s.php',  $className);

        // ファイル存在チェック
        if (!  file_exists(dirname(__FILE__) . $vaildClsFileName)) {
            var_dump('aaa');
            return false;
        }

        // クラスファイルを読込
        require_once dirname(__FILE__) . $vaildClsFileName;

        // クラスが定義されているかチェック
        if (! class_exists($className)) {
            var_dump('bbb');
            return false;
        }

        return true;
    }
}