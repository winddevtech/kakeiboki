<?php
require_once 'com/MainProcModel.php';

//ユーザー情報変更クラス
class EditProc  extends MainProcModel {

    //バリデーション
    public static function valid($formObj){
        $formObj = parent::validForm('Edit', $formObj);

        if (! empty($formObj->getErrMsg())) {
            return $formObj;
        }

        //入力したEmailが既存と同じならこれ以上処理はしない
        $current_login_email = $formObj->getParam('current_login_email');
        $userDetailObj = $formObj->getDetailObj();
        $email = $userDetailObj->getEmail();
        if ($email == $current_login_email) {
            return $formObj;
        }

        // 該当Emailを持つユーザーは既に存在するか

        require_once 'dbmanager/UserDB.php';
        $searchData = UserDB::getUserByEmail($email);
        if ($searchData) {
            $formObj = parent::validSearchDBError('Edit', $formObj);
        }

        return $formObj;
    }

    //更新処理
    public static function updateUser($userObj) {
        require_once 'IconManager.php';

        $icon_img = $userObj->getIconImg();

        //アイコンは設定されていないか
        if ($icon_img != '') {
            $icon_name = session_id() . 'icon.png'; //今後セッションidのグローバルスコープ対策を考えておく
            $icon_img = IconManager::createIconOfBlob($icon_img, $icon_name);
            $isExecute = UserDB::updateDB($userObj->getId(), $userObj->getName(), $userObj->getEmail(), $userObj->getPassword(), $userObj->getDispCount(), $icon_img);
            IconManager::deleteIconOfLocal($icon_img, $icon_name);
        }else{
            $isExecute = UserDB::updateDB($userObj->getId(), $userObj->getName(), $userObj->getEmail(), $userObj->getPassword(), $userObj->getDispCount(), $icon_img);
        }

        return $isExecute;
    }

    //表示件数を選択するプルダウンhtml文字列を生成する
    public static function createArrayToSelect($displayCount){
        require_once 'HtmlCreator.php';
        return HtmlCreator::createDisplayCount($displayCount);
    }

    /*public static function loginUpdate($param) {
        //ログインユーザー情報再設定
        $user_detail_obj->setId($login_user_obj->getId());
        $this->session->setSession('login_user_obj', serialize($user_detail_obj));

        $result_flg = Transaction::registTransaction($login_user_obj->getId(), 'ユーザー情報変更');

        // ユーザーにメール通知する
        Mail::edit($email, $user_name);
    }*/

    public static function transaction($userId, $actionName) {
        return parent::transaction($userId, $actionName);
    }

    // 表示件数ホワイトリスト
    public static function displayCountWhiteList($value) {
        require_once 'validator/SortList.php';
        return SortList::displayCount($value);
    }

    //アイコンが設定されていなければ初期アイコンを表示する
    public static function getDisplayIcon($post_icon_img){
        require_once 'IconManager.php';
        return IconManager::getDisplayIcon($post_icon_img);
    }

}