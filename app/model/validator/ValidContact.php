<?php

//お問い合わせクラス
class ValidContact {
    public static function valid($formObj){
        $contactDetailObj = $formObj->getDetailObj();
        $category_id = $contactDetailObj->getCategoryId();
        $context = $contactDetailObj->getContext();
        $errMsg = '';

        //category_id
        $rule = array (
                'require' => InputConst::CATEGORY_ID_NOT_SELECT
        );
        $errMsg = Validation::dispatch($category_id, $rule);
        if ($errMsg == '' && ! self::categorywhiteList($category_id)) {
            $errMsg = InputConst::CATEGORY_ID_ERROR;
        }
        if ($errMsg != '') $formObj->addErrMsg('category_id', $errMsg);

        //context
        $rule = array (
                'require' => InputConst::CONTEXT_NOT_INPUT,
                'size' => array('ALL', InputConst::CONTEXT_MAX_LENGTH, InputConst::CONTEXT_LENGTH_OVER)
        );
        $errMsg = Validation::dispatch($context, $rule);
        if ($errMsg != '') $formObj->addErrMsg('context', $errMsg);

        return $formObj;
    }

    // カテゴリーIDホワイトリスト
    public static function categoryWhiteList($value) {
        $value_safe = (isset(InputConst::$category_white_list[$value])) ? InputConst::$category_white_list[$value] : false;

        return $value_safe;
    }

}