<?php
class MainDetail {
    private $created_at; // 登録日時
    private $updated_at; // 更新日時
    
    public function setCreatedAt($created_at){
        $this->created_at = $created_at;
    }
    public function setUpdatedAt($updated_at){
        $this->updated_at = $updated_at;
    }
    public function getCreatedAt(){
        return $this->created_at;
    }
    public function getUpdatedAt(){
        return $this->updated_at;
    }
}
