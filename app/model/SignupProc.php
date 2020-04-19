<?php
require_once 'com/MainProcModel.php';

//ユーザー新規登録クラス
class SignupProc extends MainProcModel {

    //バリデーション
    public static function valid($formObj){

        $formObj = parent::validForm('Signup', $formObj);

        if (! empty($formObj->getErrMsg())) {
            return $formObj;
        }

        // 該当Emailを持つユーザーは既に存在するか
        $userDetailObj = $formObj->getDetailObj();
        $searchData = self::select($userDetailObj->getEmail());
        if ($searchData) {
            $formObj = parent::validSearchDBError('Signup', $formObj);
        }

        return $formObj;
    }

    //新規登録
    public static function insertUser($userObj) {
        require_once 'IconManager.php';
        require_once 'dbmanager/UserDB.php';

        $icon_img = $userObj->getIconImg();

        //アイコンは設定されていないか
        if ($icon_img != '') {
            $icon_name = session_id() . 'icon.png'; //今後セッションidのグローバルスコープ対策を考えておく
            $icon_img = IconManager::createIconOfBlob($icon_img, $icon_name);
            $isExecute = UserDB::insertDB($userObj->getName(), $userObj->getEmail(), $userObj->getPassword(), $userObj->getDispCount(), $icon_img);
            IconManager::deleteIconOfLocal($icon_img, $icon_name);
        }else{
            $isExecute = UserDB::insertDB($userObj->getName(), $userObj->getEmail(), $userObj->getPassword(), $userObj->getDispCount(), $icon_img);
        }

        return $isExecute;
    }

    // ログイン処理用のユーザー情報をEmailで取得する
    public static function select($email) {
        require_once 'dbmanager/UserDB.php';
        $user_row = UserDB::getUserByEmail($email);

        return $user_row;
    }

    //表示件数を選択するプルダウンhtml文字列を生成する
    public static function createArrayToSelect($displayCount){
        require_once 'HtmlCreator.php';
        return HtmlCreator::createDisplayCount($displayCount);
    }

    public static function transaction($userId, $actionName) {
        return parent::transaction($userId, $actionName);
    }

    //アイコンが設定されていなければ初期アイコンを表示する
    public static function getDisplayIcon($post_icon_img){
        require_once 'IconManager.php';
        return IconManager::getDisplayIcon($post_icon_img);
    }

    // 表示件数ホワイトリスト
    public static function displayCountWhiteList($value) {
        require_once 'validator/SortList.php';
        return SortList::displayCount($value);
    }

}