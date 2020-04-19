<?php
require_once 'com/MainProcModel.php';
// ログイン情報操作クラス
class LoginProc extends MainProcModel {
    //バリデーション
    public static function valid($formObj){
        return parent::validForm('Login', $formObj);
    }
}