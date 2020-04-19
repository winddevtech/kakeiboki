<?php
require_once 'com/MainProcModel.php';
//Email認証クラス
class AuthProc extends MainProcModel {

    //バリデーション
    public static function valid($formObj){
        $formObj = parent::validForm('Auth', $formObj);

        if (! empty($formObj->getErrMsg())) {
            return $formObj;
        }

        // 該当Emailを持つユーザーはなしか
        $userDetailObj = $formObj->getDetailObj();
        $searchData = self::select($userDetailObj);
        if (! $searchData) {
            $formObj = parent::validSearchDBError('Auth', $formObj);
        }

        return $formObj;
    }

    //仮パスワードを生成してDBに登録する
    public static function updateUser($userObj) {
        require_once 'dbmanager/UserDB.php';

        $kari_password = Util::generatePassword();

        $isExecute = UserDB::updateKariPassword($userObj->getEmail(), $kari_password);

        return $isExecute;
    }

    //仮パスワードが登録されたユーザー情報を取得する
    public static function select($userDetailObj) {
        require_once 'dbmanager/UserDB.php';

        $searchData = UserDB::getUserByEmail($userDetailObj->getEmail());

        return $searchData;
    }


}