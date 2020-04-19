<?php
require_once '../com/detail/MainDetail.php';

// auto_loginテーブル操作クラス
class AutoLogin extends MainDetail {
    private $id; // 管理ID
    private $user_id; // ユーザー管理ID
    private $c_key; // cookieデータ
    private $expire; // cookieの有効期間
    
    public function __construct(){
    }
    public function setId($id){
        $this->id = $id;
    }
    public function setUserId($user_id){
        $this->user_id = $user_id;
    }
    public function setCKey($c_key){
        $this->c_key = $c_key;
    }
    public function setExpire($expire){
        $this->expire = $expire;
    }
    public function getId(){
        return $this->id;
    }
    public function getUserId(){
        return $this->user_id;
    }
    public function getCKey(){
        return $this->c_key;
    }
    public function getExpire(){
        return $this->expire;
    }
}