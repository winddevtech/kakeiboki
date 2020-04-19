<?php
require_once 'RequestVariables.php';
class UrlParameter extends RequestVariables {
    protected function setValues(){
        if (isset($_GET['param'])) {
            // パラメーター取得（末尾の / は削除）
            $param = ereg_replace('/?$', '', $_GET['param']);
            
            $params = array ();
            if ('' != $param) {
                // パラメーターを / で分割
                $params = explode('', $param);
            }
            
            if (2 < count($params)) {
                foreach ($params as $param) {
                    // '_'で分割
                    $splited = explode('_', $param);
                    if (2 == count($splited)) {
                        $key = $splited[0];
                        $val = $splited[1];
                        $this->_values[$key] = $val;
                    }
                }
            }
        }
    }
}