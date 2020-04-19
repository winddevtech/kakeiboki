<?php
//フォームオブジェクトクラス
class Form {
    private $detail_obj = null; //詳細オブジェクト
    private $err_msg = array(); //エラーメッセージ
    private $param = array(); //DBに登録しないパラメータ
    private $isParamErrParam = array(); //パラメータはエラーか

    public function __construct($detail_obj = null){
        $this->detail_obj = $detail_obj;
    }

    public function setDetailObj($detailObj) {
        return $this->detail_obj = $detailObj;
    }

    public function getDetailObj() {
        return $this->detail_obj;
    }

    public function addParam($key, $value){
        $this->param[$key] = $value;
    }

    public function getParam($key) {
        return $this->param[$key];
    }

    public function addErrMsg($key, $err_msg) {
        $this->err_msg[$key] = $err_msg;
    }
    public function getErrMsg() {
        return $this->err_msg;
    }

    public function addisErrParam($key, $boolean) {
        $this->isParamErrParam[$key] = $boolean;
    }
    public function hasErr($key) {
        return $this->isParamErrParam[$key];
    }
}
