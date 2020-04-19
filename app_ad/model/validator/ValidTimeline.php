<?php

//タイムラインクラス
class ValidTimeline {
    public static function valid($formObj){
        $contactDetailObj = $formObj->getDetailObj();
        $context = $contactDetailObj->getContext();
        $errMsg = '';

        //context
        $rule = array (
                'require' => InputConst::CONTEXT_NOT_INPUT,
                'size' => array('ALL', InputConst::CONTEXT_MAX_LENGTH, InputConst::CONTEXT_LENGTH_OVER)
        );
        $errMsg = Validation::dispatch($context, $rule);
        if ($errMsg != '') $formObj->addErrMsg('context', $errMsg);

        return $formObj;
    }
}