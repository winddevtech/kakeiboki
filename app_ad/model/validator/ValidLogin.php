<?php
//ログインクラス
class ValidLogin {
    public static function valid($formObj) {
        $adminDetailObj = $formObj->getDetailObj();
        $loginId = $adminDetailObj->getLoginId();
        $password = $adminDetailObj->getPassword();

        $errMsg = '';

        //login_id
        $rule = array (
                'require' => 'ログインIDが未入力です。',
                'compare' => array('このログインIDは登録されていません。', 'kakeiboki')
        );
        $errMsg = Validation::dispatch($loginId, $rule);
        if ($errMsg != '') $formObj->addErrMsg('login_id', $errMsg);

        //password
        $rule = array (
                'require' => 'パスワードが未入力です。'
        );
        $errMsg = Validation::dispatch($password, $rule);
        if ($errMsg != '') $formObj->addErrMsg('password', $errMsg);

        if (! empty($errMsg)) {
            return $formObj;
        }

        if ($password != 'login_admin') {
            $formObj->addErrMsg('password', 'パスワードが正しくありません。');
            return $formObj;
        }

        return $formObj;
    }

    public static function setValidSearchError($formObj) {
        $formObj->addErrMsg('email', InputConst::EMAIL_ALREADY_REGIST_DB);
        return $formObj;
    }
}