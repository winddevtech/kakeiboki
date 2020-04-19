<?php
require_once dirname(__FILE__) . '/../com/detail/MainDetail.php';

// 家計簿情報データクラス
class Budget extends MainDetail {
    private $id; // 管理ID
    private $user_id; // ユーザー管理ID
    private $creation_date; // 仕訳発生日
    private $use_item; // 用途ID
    private $price; // 金額
    private $summary; // 摘要

    public function __construct() {
    }
    public function setId($id) {
        $this->id = $id;
    }
    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }
    public function setCreationDate($creation_date) {
        $this->creation_date = $creation_date;
    }
    public function setUseItem($use_item) {
        $this->use_item = $use_item;
    }
    public function setPrice($price) {
        $this->price = $price;
    }
    public function setSummary($summary) {
        $this->summary = $summary;
    }

    public function getId() {
        return $this->id;
    }
    public function getUserId() {
        return $this->user_id;
    }
    public function getCreationDate() {
        return $this->creation_date;
    }
    public function getUseItem() {
        return $this->use_item;
    }
    public function getPrice() {
        return $this->price;
    }
    public function getSummary() {
        return $this->summary;
    }
}