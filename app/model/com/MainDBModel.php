<?php
require_once dirname(__FILE__) . '/../../../framework/ModelBase.php';
require_once dirname(__FILE__) . '/../../../framework/StrProc.php';
require_once dirname(__FILE__) . '/../../../framework/Util.php';


abstract class MainDBModel extends ModelBase {

    public static function outputErrlog($filename, $line, $message) {
        Util::logging($filename, $line, $message);
    }
}
