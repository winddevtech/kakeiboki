<?php
require_once 'detail/User.php';
require_once 'const/InputConst.php';
require_once 'com/MainProcModel.php';
// ログイン情報操作クラス
class LoginProc  extends MainProcModel {

    //バリデーション
    public static function valid($formObj){
        //入力エラーはあるか
        $formObj = parent::validForm('Login', $formObj);
        if (! empty($formObj->getErrMsg())) {
            return $formObj;
        }

        //DBに該当するEmailは存在しないか
        $user = self::searchUser($formObj);
        if (! $user) {
            return parent::validFormSearch('Login', $formObj);
        }

        //通常のログイン認証でエラーはあるか
        $formObj = ValidLogin::validBaseLogin($formObj, $user);
        if (! empty($formObj->getErrMsg())) {
            //仮パスワードによるログイン認証でエラーはあるか
            $formObj = ValidLogin::validKariLogin($formObj, $user);
            if (! empty($formObj->getErrMsg())) {
                return $formObj;
            }

            //仮パスワードを初期化する
            $user = self::updateKariPassword($formObj);
        }

        $userDetailObj = $formObj->getDetailObj();
        $password = $userDetailObj->getPassword(); //フォームから入力したパスワードを抜き出す

        //オブジェクト設定
        $userDetailObj = self::createLoginObject($userDetailObj, $user);
        $formObj->setDetailObj($userDetailObj);


        //2重ログインチェック
        $formObj = ValidLogin::dobuleLoginCheck($password, $formObj, session_id());
        // ログインエラーはあるか
        if (! empty($formObj->getErrMsg())) {
            return $formObj;
        }

        return $formObj;
    }

    //検索バリデーション
    private static function searchUser($formObj){
        require_once 'dbmanager/UserDB.php';

        $userDetailObj = $formObj->getDetailObj();
        $email = $userDetailObj->getEmail();

        return UserDB::getUserbyEmail($email);
    }

    // 仮パスワードを初期化する
    private static function updateKariPassword($formObj){
        $userDetailObj = $formObj->getDetailObj();
        $email = $userDetailObj->getEmail();
        $password = $user_detail_obj->getPassword();

        UserDB::initKariPassword($email, $password);

        return UserDB::getUserbyEmail($email);
    }

    //ログインユーザーオブジェクトを生成する
    private static function createLoginObject($userDetailObj, $userAuthData) {
        $userDetailObj->setId($userAuthData['id']);
        $userDetailObj->setName($userAuthData['name']);
        $userDetailObj->setPassword($userAuthData['password']);
        $userDetailObj->setKariPassword($userAuthData['kari_password']);
        $userDetailObj->setKariCreatedAt($userAuthData['kari_created_at']);
        $userDetailObj->setEmail($userAuthData['email']);
        $userDetailObj->setDispCount($userAuthData['display_count']);
        require_once 'IconManager.php';
        $icon_img = IconManager::pullIconFromDB($userAuthData['icon']);
        $userDetailObj->setIconImg($icon_img);
        $userDetailObj->setSessionId($userAuthData['session_id']);
        $userDetailObj->setLastloginAt($userAuthData['lastlogin_at']);
        $userDetailObj->setCreatedAt($userAuthData['created_at']);
        $userDetailObj->setUpdatedAt($userAuthData['updated_at']);

        return $userDetailObj;
    }

    // 古いCookie情報を削除
    public static function deleteOldCookie() {
        require_once 'CookieManager.php';

        if (CookieManager::isHasCookie()) {
            require_once 'dbmanager/AutoLoginDB.php';

            // 古いCookie情報を削除
            $auto_login_key = CookieManager::getCookie();
            AutoLoginDB::delete($auto_login_key);
            CookieManager::delete();
        }
    }

    // 自動でログイン処理
    public static function autoLoginProc($userId, $auto_login_flg){
        require_once 'CookieManager.php';
        require_once dirname(__FILE__) . '/../../framework/StrProc.php';
        require_once 'dbmanager/AutoLoginDB.php';

        // cookieを新規登録する
        $auto_login_key = CookieManager::generateCookieKey();
        $expire = CookieManager::generateExpire();
        CookieManager::setCookie($auto_login_key, $expire);

        // cookieをDBに新規登録する
        $expire = StrProc::formatDateToTimestamp($expire);
        AutoLoginDB::insertDB($userId, $auto_login_key, $expire);
    }


    // cookie情報を削除
    public static function updateUserSession($user_id, $session_id = null, $last_login_at = null) {
        require_once 'dbmanager/UserDB.php';
        UserDB::updateUserSession($user_id, $session_id, $last_login_at);
    }

    // DB上のCookie情報を削除
    public static function deleteCookie($auto_login_key) {
        require_once 'dbmanager/AutoLoginDB.php';
        AutoLoginDB::delete($auto_login_key);
    }

    //家計簿情報削除処理
    public static function deleteBudget($user_id) {
        require_once 'dbmanager/BudgetDB.php';
        BudgetDB::delete($user_id);
    }

    //お問い合わせ情報を削除する
    public static function deleteContact($user_id){
        require_once 'dbmanager/ContactDB.php';
        ContactDB::delete($user_id);
    }

    // DBのcookieを削除する
    public static function deleteCookieByUserId($user_id){
        require_once 'dbmanager/AutoLoginDB.php';
        AutoLoginDB::deleteByUserId($user_id);
    }

    //トランザクションをDBから削除する
    public static function deleteTransaction($user_id){
        require_once 'dbmanager/TransactionDB.php';
        TransactionDB::deleteDB($user_id);
    }

    //ユーザー情報をDBから削除する
    public static function deleteUser($user_id){
        require_once 'dbmanager/UserDB.php';
        UserDB::delete($user_id);
    }

    // DB上にあるユーザーのCookie情報を検索する
    // 【引数】自動ログインキー
    // 【戻り値】DBに登録されてるcookie情報
    public static function getCookieInDB($auto_login_key){
        require_once 'dbmanager/AutoLoginDB.php';
        AutoLoginDB::getCookieInDB($auto_login_key);
    }

    // ユーザIDでユーザ情報を取得する
    // 【引数】ユーザID
    // 【戻り値】成功時：ユーザ情報、失敗時：false
    public static function getUserbyUserId($user_id){
        require_once 'dbmanager/UserDB.php';
        return UserDB::getUserbyUserId($user_id);
    }

    // Cookie情報を削除
    public static function deleteLogoutCookie($sessionName) {
        require_once 'CookieManager.php';

        if (CookieManager::isHasCookie()) {
            require_once 'dbmanager/AutoLoginDB.php';

            // cookie情報を削除
            $auto_login_key = CookieManager::getCookie();
            AutoLoginDB::deleteDB($auto_login_key);
            CookieManager::delete();

            //cookieを初期化
            CookieManager::init($sessionName);
        }
    }
}