<?php
require_once dirname(__FILE__) . '/../com/detail/MainDetail.php';

// 更新履歴情報詳細クラス
class History extends MainDetail {
    private $id; // 管理ID
    private $number; // 履歴番号
    private $context; // 更新内容
    
    public function __construct(){
    }
    public function setId($id){
        $this->id = $id;
    }
    public function setNumber($number){
        $this->number = $number;
    }
    public function setContext($context){
        $this->context = $context;
    }
    public function getId(){
        return $this->id;
    }
    public function getNumber(){
        return $this->number;
    }
    public function getContext(){
        return $this->context;
    }
}