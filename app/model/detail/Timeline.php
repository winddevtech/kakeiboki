<?php
require_once dirname(__FILE__) . '/../com/detail/MainDetail.php';

// タイムライン情報クラス
class Timeline extends MainDetail {
    private $id; // 管理ID
    private $sender; // 送信者
    private $context; // 本文
    
    public function __construct(){
    }
    public function setId($id){
        $this->id = $id;
    }
    public function setContext($context){
        $this->context = $context;
    }
    public function setSender($sender){
        $this->sender = $sender;
    }
    public function getId(){
        return $this->id;
    }
    public function getContext(){
        return $this->context;
    }
    public function getSender(){
        return $this->sender;
    }
}