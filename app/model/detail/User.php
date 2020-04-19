<?php
require_once dirname(__FILE__) . '/../com/detail/MainDetail.php';

// user（ユーザー情報）データクラス
class User extends MainDetail {
    private $id; // 管理ID
    private $name; // ユーザー名
    private $email; // Eメール
    private $password; // パスワード
    private $kari_password; // 仮パスワード
    private $kari_created_at; // 仮パスワード生成日時
    private $display_count; // 一覧表示件数
    private $icon_img; //アイコン画像
    private $session_id; // セッションID
    private $lastlogin_at; // 最終ログイン日時
    
    public function __construct() {
    }
    public function setId($id) {
        $this->id = $id;
    }
    public function setName($name) {
        $this->name = $name;
    }
    public function setPassword($password) {
        $this->password = $password;
    }
    public function setKariPassword($kari_password) {
        $this->kari_password = $kari_password;
    }
    public function setKariCreatedAt($kari_created_at) {
        $this->kari_created_at = $kari_created_at;
    }
    public function setEmail($email) {
        $this->email = $email;
    }
    public function setDispCount($display_count) {
        $this->display_count = $display_count;
    }
    public function setIconImg($icon_img) {
        $this->icon_img = $icon_img;
    }
    public function setSessionId($session_id) {
        $this->session_id = $session_id;
    }
    public function setLastloginAt($lastlogin_at) {
        $this->lastlogin_at = $lastlogin_at;
    }
    public function getId() {
        return $this->id;
    }
    public function getName() {
        return $this->name;
    }
    public function getPassword() {
        return $this->password;
    }
    public function getKariPassword() {
        return $this->kari_password;
    }
    public function getKariCreatedAt() {
        return $this->kari_created_at;
    }
    public function getEmail() {
        return $this->email;
    }
    public function getDispCount() {
        return $this->display_count;
    }
    public function getIconImg() {
        return $this->icon_img;
    }
    public function getSessionId() {
        return $this->session_id;
    }
    public function getLastloginAt() {
        return $this->lastlogin_at;
    }
}