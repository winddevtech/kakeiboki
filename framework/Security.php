<?php
/**
 * セキュリティ対策クラス
 */
class Security {
    /**
     * HTMLエスケープ
     * 引数：HTMLエスケープする文字列 戻り値：HTMLエスケープした文字列
     */
    public static function h($original_str){
        return htmlspecialchars($original_str, ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * トークン発行
     */
    public static function generateToken(){
        return sha1(uniqid(mt_rand(), true));
    }
    
    /**
     * トークンチェック
     */
    public static function checkToken(){
        if (empty($_SESSION['sstoken']) || ($_SESSION['sstoken'] != $_POST['token'])) {
            return false;
        }
        return true;
    }
}
?>