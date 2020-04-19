<?php
require_once 'SortList.php';

//会計クラス
class ValidAccounting {

    public static function valid($formObj){
        $start_date = $formObj->getParam('start_date');
        $end_date = $formObj->getParam('end_date');
        $use_item_id = $formObj->getParam('use_item_id');

        $rule = array (
                'format_date' => array(InputConst::FORMAT_DATE_YM_DD)
        );

        $boolean = Validation::dispatchNonMsg($start_date, $rule);
        $formObj->addisErrParam('start_date', $boolean);

        $boolean = Validation::dispatchNonMsg($end_date, $rule);
        $formObj->addisErrParam('end_date', $boolean);

        $isExist = SortList::useItemId($use_item_id);
        $boolean = false;
        if ($isExist) {
            $boolean = true;
        }
        $formObj->addisErrParam('use_item_id', $boolean);

        return $formObj;
    }

    public static function validFormatCalenderDate($date) {
        $rule = array (
                'format_date' => array(InputConst::FORMAT_DATE_YM)
        );

        $boolean = Validation::dispatchNonMsg($date, $rule);
        return $boolean;
    }

    public static function validFormatDate($date) {
        $rule = array (
                'format_date' => array(InputConst::FORMAT_DATE_YM_DD)
        );

        $boolean = Validation::dispatchNonMsg($date, $rule);
        return $boolean;
    }
}