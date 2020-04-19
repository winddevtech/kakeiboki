<?php
//データインポートクラス
class ValidImport{

    public static function valid($formObj) {
        $import_detail_obj = $formObj->getDetailObj();
        $file = $import_detail_obj->getFile();
        $rsl_errmsg = null;

        if ($file['tmp_name'] == '') {
            $rsl_errmsg =  InputConst::IMPORT_FILE_NOT_SET;
        } elseif (! preg_match('/^.+.csv$/', $file['name'])) {
            $rsl_errmsg =  InputConst::IMPORT_FILE_OTHER_FORMAT;
        } elseif ($file['size'] > InputConst::IMPORT_FILE_MAX_SIZE) {
            $rsl_errmsg =  InputConst::IMPORT_FILE_LENGTH_OVER;
        }
        if (! is_null($rsl_errmsg)) {
            $formObj->addErrMsg('import_file', $rsl_errmsg);
        }

        return $formObj;
    }

    //家計簿情報をチェックする
    public static function rowData($creation_date, $use_item_id, $price, $summary) {
        $rule = array (
                'require' => '',
                'format_date' => array(InputConst::FORMAT_DATE_YM_DD),
                'is_date' => ''
        );
        if (! Validation::dispatchNonMsg($creation_date, $rule)) {
            return false;
        }

        require_once 'SortList.php';
        $value_safe = SortList::useItemId($use_item_id);
        if (! $value_safe) {
            return false;
        }

        $rule = array (
                'require' => '',
                'format_number' => '',
                'is_min_number' => '',
                'is_max_number' => array(InputConst::PRICE_MAX_SIZE)
        );
        if (! Validation::dispatchNonMsg($price, $rule)) {
            return false;
        }

        $rule = array (
                'size' => array('ALL', InputConst::SUMMARY_MAX_LENGTH)
        );
        if (! Validation::dispatchNonMsg($summary, $rule)) {
            return false;
        }

        return true;
    }
}