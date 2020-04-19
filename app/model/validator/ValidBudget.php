<?php
require_once 'SortList.php';

//家計簿情報クラス
class ValidBudget {
    public static function valid($formObj){
        $budget_detail_obj = $formObj->getDetailObj();

        $errMsg = '';

        //仕訳発生日チェック
        $rule = array (
                'require' => InputConst::USE_ITEM_ID_NOT_SELECT,
                'format_date' => InputConst::CREATION_DATE_FORMAT_ERROR,
                'is_date' => InputConst::CREATION_DATE_NOT_DAY
        );
        $errMsg = Validation::dispatch($budget_detail_obj->getCreationDate(), $rule);
        if ($errMsg != '') $formObj->addErrMsg('creation_date', $errMsg);

        //用途IDチェック
        $rule = array (
                'require' => InputConst::USE_ITEM_ID_NOT_SELECT,
        );
        $errMsg = Validation::dispatch($budget_detail_obj->getUseItem(), $rule);
        if ($errMsg == '') {
            $value_safe = SortList::useItemId($budget_detail_obj->getUseItem());
            if (! $value_safe) {
                $errMsg = InputConst::USE_ITEM_ID_ERROR;
            }
        }
        if ($errMsg != '') {
            $formObj->addErrMsg('use_item_id', $errMsg);
        }

        //金額チェック
        $rule = array (
                'require' => InputConst::PRICE_NOT_INPUT,
                'format_number' => InputConst::PRICE_FORMAT_ERROR,
                'is_min_number' => InputConst::PRICE_ZERO_UNDER,
                'is_max_number' => array(InputConst::PRICE_MAX_SIZE, InputConst::PRICE_MAX_NUMBER_OVER)
        );
        $errMsg = Validation::dispatch($budget_detail_obj->getPrice(), $rule);
        if ($errMsg != '') $formObj->addErrMsg('price', $errMsg);

        //summary
        $rule = array (
                'size' => array('ALL', InputConst::SUMMARY_MAX_LENGTH, InputConst::SUMMARY_MAX_NUMBER_OVER)
        );
        $errMsg = Validation::dispatch($budget_detail_obj->getSummary(), $rule);
        if ($errMsg != '') $formObj->addErrMsg('summary', $errMsg);

        return $formObj;
    }
}