<?php
require_once 'RequestVariables.php';

/**
 * Files変数クラス
 */
class Files extends RequestVariables {
    protected function setValues(){
        foreach ($_FILES as $key => $value) {
            $this->_values[$key] = $value;
        }
    }
}
