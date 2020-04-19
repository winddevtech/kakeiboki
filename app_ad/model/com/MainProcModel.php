<?php
require_once dirname(__FILE__) . '/../../../framework/ModelBase.php';
require_once dirname(__FILE__) . '/../../../framework/StrProc.php';
require_once dirname(__FILE__) . '/../../../framework/Util.php';


abstract class MainProcModel extends ModelBase {

    //バリデーション
    protected static function validForm($className, $formObj){
        require_once dirname(__FILE__) . '/../validator/Validator.php';

        return Validator::valid('Valid'.$className, $formObj);
    }

    //バリデーション
    protected static function validSearchDBError($className, $formObj){
        require_once dirname(__FILE__) . '/../validator/Validator.php';

        return Validator::validSearchError($className, $formObj);
    }

    //バリデーション
    protected static function validFormSearch($className, $formObj){
        require_once dirname(__FILE__) . '/../validator/Validator.php';

        return Validator::validSearch($className, $formObj);
    }

    protected static function transaction($userId, $actionName) {
        require_once dirname(__FILE__) . '/../dbmanager/TransactionDB.php';

        $isExecute = TransactionDB::insert($userId, $actionName);

        return $isExecute ? true : false;
    }
}
