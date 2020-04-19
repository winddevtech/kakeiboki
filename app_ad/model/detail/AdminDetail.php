<?php
class AdminDetail {
    private $login_id; // ログインID
    private $password; // パスワード

    public function __construct(){
    }
    public function setLoginId($login_id){
        $this->login_id = $login_id;
    }
    public function setPassword($password){
        $this->password = $password;
    }
    public function getLoginId(){
        return $this->login_id;
    }
    public function getPassword(){
        return $this->password;
    }
}