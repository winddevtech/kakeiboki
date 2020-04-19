<?php

class ImportData {
    private $file;
    private $ok_data_count;
    private $ng_data_count;
    private $ok_data_array = array ();
    private $flg;
    
    public function __construct(){
    }
    public function setFile($file){
        $this->file = $file;
    }
    public function setHeaderFlg($flg){
        $this->flg = $flg;
    }
    public function setOkDataArray($ok_data_array){
        $this->ok_data_array = $ok_data_array;
    }
    public function setOkDataCount($ok_data_count){
        $this->ok_data_count = $ok_data_count;
    }
    public function setNgDataCount($ng_data_count){
        $this->ng_data_count = $ng_data_count;
    }
    public function getFile(){
        return $this->file;
    }
    public function getHeaderFlg(){
        return $this->flg;
    }
    public function getOkDataArray(){
        return $this->ok_data_array;
    }
    public function getOkDataCount(){
        return $this->ok_data_count;
    }
    public function getNgDataCount(){
        return $this->ng_data_count;
    }
}