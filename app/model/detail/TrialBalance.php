<?php
// 試算表クラス
class TrialBalance {
    private $debit_balance;//借方残高
    private $debit_sum;//借方合計
    private $subject_id; // 仕訳科目ID
    private $class_id; // 分類ID
    private $subject_name; // 仕訳科目名
    private $credit_balance;//貸方合計
    private $credit_sum;//貸方残高
    
    public function __construct() {
    }
    public function setDebitBalance($debit_balance) {
        $this->debit_balance = $debit_balance;
    }
    public function setDebitSum($debit_sum) {
        $this->debit_sum = $debit_sum;
    }
    public function setSubjectId($subject_id) {
        $this->subject_id = $subject_id;
    }
    
    public function setSubjectName($subject_name) {
        $this->subject_name = $subject_name;
    }
    public function setClassId($class_id) {
        $this->class_id = $class_id;
    }
    public function setCreditBalance($credit_balance) {
        $this->credit_balance = $credit_balance;
    }
    public function setCreditSum($credit_sum) {
        $this->credit_sum = $credit_sum;
    }
    
    public function getDebitBalance() {
        return $this->debit_balance;
    }
    public function getDebitSum() {
        return $this->debit_sum;
    }
    public function getSubjectId() {
        return $this->subject_id;
    }
    
    public function getSubjectName() {
        return $this->subject_name;
    }
    public function getClassId() {
        return $this->class_id;
    }
    public function getCreditBalance() {
        return $this->credit_balance;
    }
    public function getCreditSum() {
        return $this->credit_sum;
    }
}