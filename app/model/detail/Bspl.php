<?php
// 決算クラス
class Bspl {
    private $class_id; // 分類ID
    private $subject_name; // 仕訳科目名
    private $money; //金額
    
    public function __construct() {
    }

    public function setClassId($class_id) {
        $this->class_id = $class_id;
    }
    public function setSubjectName($subject_name) {
        $this->subject_name = $subject_name;
    }
    
    public function setMoney($money) {
        $this->money = $money;
    }
    
    public function getClassId() {
        return $this->class_id;
    }
    public function getSubjectName() {
        return $this->subject_name;
    }
    public function getMoney() {
        return $this->money;
    }
}