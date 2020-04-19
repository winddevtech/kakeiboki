<?php

//Email認証クラス
class ValidAuth {
    //メール認証
    public static function valid($formObj) {
        $userDetailObj = $formObj->getDetailObj();
        $email = $userDetailObj->getEmail();
        $errMsg = '';

        $rule = array ('require' => InputConst::EMAIL_NOT_INPUT, 'format_email' => InputConst::EMAIL_FORMAT_ERROR);
        $errMsg = Validation::dispatch($email, $rule);

        if ($errMsg != '') {
            $formObj->addErrMsg('email', $errMsg);
        }

        return $formObj;
    }

    public static function setValidSearchError($formObj) {
        $formObj->addErrMsg('email', InputConst::EMAIL_NOT_REGIST_DB);
        return $formObj;
    }

}