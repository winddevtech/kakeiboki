<?php
require_once dirname(__FILE__) . '/../../../framework/libs/password.php';

//ログインクラス
class ValidLogin {
    public static function valid($formObj) {
        $userDetailObj = $formObj->getDetailObj();
        $email = $userDetailObj->getEmail();
        $password = $userDetailObj->getPassword();

        $errMsg = '';

        //Email
        $rule = array (
                'require' => InputConst::EMAIL_NOT_INPUT,
                'format_email' => InputConst::EMAIL_FORMAT_ERROR
        );
        $errMsg = Validation::dispatch($email, $rule);
        if ($errMsg != '') $formObj->addErrMsg('email', $errMsg);

        //password
        $rule = array (
                'require' => InputConst::PASSWORD_NOT_INPUT
        );
        $errMsg = Validation::dispatch($password, $rule);
        if ($errMsg != '') $formObj->addErrMsg('password', $errMsg);

        return $formObj;
    }

    public static function validSearch($formObj) {
        $formObj->addErrMsg('email', InputConst::EMAIL_NOT_REGIST_DB);
        return $formObj;
    }

    //ログイン認証
    public static function validBaseLogin($formObj, $user) {
        $userDetailObj = $formObj->getDetailObj();
        $password = $userDetailObj->getPassword();

        // DB上にある復号した暗号化パスワードと入力されたパスワードは一致するか
        if (! password_verify($password, $user['password'])) {
            $formObj->addErrMsg('password', InputConst::PASSWORD_NOT_LOGIN);
        }

        return $formObj;
    }

    //仮パスワードでのログイン認証
    public static function validKariLogin($formObj, $user) {
        $userDetailObj = $formObj->getDetailObj();
        $password = $userDetailObj->getPassword();

        //仮パスワードによるログイン認証を行う
        $now = StrProc::getTimeStampStr();
        if ($user['kari_created_at'] < $now) {
            $formObj->addErrMsg('password', InputConst::PASSWORD_NOT_LOGIN);
        }

        // DB上にある復号した暗号化パスワードと入力されたパスワードは一致するか
        if (! password_verify($password, $user['kari_password'])) {
            $formObj->addErrMsg('password', InputConst::PASSWORD_NOT_LOGIN);
        }

        return $formObj;
    }


    // 2重ログインチェック
    public static function dobuleLoginCheck($password, $formObj, $session_id = null) {
        $userDetailObj = $formObj->getDetailObj();

        // 暗号化されたログインパスワードと照合
        if (! (password_verify($password, $userDetailObj->getPassword()) || password_verify($password, $userDetailObj->getKariPassword()))) {
            $formObj->addErrMsg('password', InputConst::PASSWORD_NOT_LOGIN);
            return $formObj;
        }

        // 別のPC・ブラウザからログインしようとしたらエラーメッセージを出力する（2重ログイン対策）
        $isBoolean = self::checkLoginSession($userDetailObj->getSessionId(), $userDetailObj->getLastloginAt(), $session_id);
        if (! $isBoolean) {
            $formObj->addErrMsg('multiple', InputConst::MULTIPLE_LOGIN_ERROR);
        }

        return $formObj;
    }

    // 多重ログインチェック
    // 【引数】DBセッションID、DB最終ログイン日時
    // 【戻り値】異常無し：true、多重ログイン時：false
    private static function checkLoginSession($db_session_id, $db_last_login_at, $session_id) {
        if ($db_session_id == null) {
            return true;
        }

        // セッションIDはDBに登録されているものと一致するか
        if ($db_session_id == $session_id) {
            return true;
        }

        $compare_time = date('Y-m-d H:i:s', strtotime('-30 minute')); // 30分前の日時

        // DBに登録されている最終ログイン時間は30分を超えているか
        if ($db_last_login_at <= $compare_time) {
            return true;
        }

        return false; // 多重ログイン防止
    }

}