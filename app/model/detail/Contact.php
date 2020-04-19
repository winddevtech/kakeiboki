<?php
require_once dirname(__FILE__) . '/../com/detail/MainDetail.php';

// contactテーブル操作クラス
class Contact extends MainDetail {
    private $id; // 管理ID
    private $user_id; // ユーザー管理ID
    private $category_id; // カテゴリID
    private $category_name; // カテゴリ名
    private $context; // 本文
    private $reply_status; // 返信ステータス
    
    public function __construct(){
    }
    public function setId($id){
        $this->id = $id;
    }
    public function setUserId($user_id){
        $this->user_id = $user_id;
    }
    public function setCategoryId($category_id){
        $this->category_id = $category_id;
    }
    public function setCategoryName($category_name){
        $this->category_name = $category_name;
    }
    public function setContext($context){
        $this->context = $context;
    }
    public function setReplyStatusId($reply_status){
        $this->reply_status = $reply_status;
    }
    
    public function getId(){
        return $this->id;
    }
    public function getUserId(){
        return $this->user_id;
    }
    public function getCategoryId(){
        return $this->category_id;
    }
    public function getCategoryName(){
        return $this->category_name;
    }
    public function getContext(){
        return $this->context;
    }
    public function getReplyStatusId(){
        return $this->reply_status;
    }
}