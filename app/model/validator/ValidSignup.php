<?php
require_once 'SortList.php';

//ユーザー登録クラス
class ValidSignup {

    public static function valid($formObj){
        $user_detail_obj = $formObj->getDetailObj();
        $password_conf = $formObj->getParam('password_conf');

        $errMsg = '';

        //username
        $rule = array (
                'require' => InputConst::USER_NAME_NOT_INPUT,
                'size' => array('ALL', InputConst::USER_NAME_MAX_LENGTH, InputConst::USER_NAME_LENGTH_OVER)
        );
        $errMsg = Validation::dispatch($user_detail_obj->getName(), $rule);
        if ($errMsg != '') $formObj->addErrMsg('user_name', $errMsg);

        //email
        $rule = array (
                'require' => InputConst::EMAIL_NOT_INPUT,
                'format_email' => InputConst::EMAIL_FORMAT_ERROR,
                'size' => array('BITE', InputConst::EMAIL_MAX_LENGTH, InputConst::EMAIL_LENGTH_OVER)
        );
        $errMsg = Validation::dispatch($user_detail_obj->getEmail(), $rule);
        if ($errMsg != '') {
            $formObj->addErrMsg('email', $errMsg);
        }
        if ($errMsg != '') $formObj->addErrMsg('email', $errMsg);

        //password
        $rule = array (
                'require' => InputConst::PASSWORD_NOT_INPUT,
                'betweenBite' => array(InputConst::PASSWORD_LENGTH_RANGE_OVER,
                        InputConst::PASSWORD_MIN_LENGTH, InputConst::PASSWORD_MAX_LENGTH)
        );
        $errMsg_pass = Validation::dispatch($user_detail_obj->getPassword(), $rule);
        if ($errMsg_pass != '') $formObj->addErrMsg('password', $errMsg);


        //password_conf
        $rule = array (
                'require' => InputConst::PASSWORD_NOT_INPUT,
                'betweenBite' => array(InputConst::PASSWORD_LENGTH_RANGE_OVER,
                        InputConst::PASSWORD_MIN_LENGTH, InputConst::PASSWORD_MAX_LENGTH)
        );
        $errMsg_passConf = Validation::dispatch($password_conf, $rule);
        if ($errMsg_passConf != '') $formObj->addErrMsg('password_conf', $errMsg);


        if ($errMsg_pass != '' && $errMsg_passConf != '') {
            if ($user_detail_obj->getPassword() != $password_conf) {
                $formObj->addErrMsg('password', InputConst::PASSWORD_NOT_AGREEMENT);
                $formObj->addErrMsg('password_conf', InputConst::PASSWORD_NOT_AGREEMENT);
            }
        }

        $isError = SortList::displayCount($user_detail_obj->getDispCount());
        if (! $isError) {
            $formObj->addErrMsg('display_count', InputConst::DISP_COUNT_ERROR);
        }

        if ($user_detail_obj->getIconImg() != '') {
            //icon
            $rule = array (
                    'icon_format' => array(InputConst::ICON_FORMAT_ERROR)
            );
            $errMsg = Validation::dispatch($user_detail_obj->getIconImg(), $rule);
            if ($errMsg != '') {
                $formObj->addErrMsg('icon_img', $errMsg);
            }
        }

        return $formObj;
    }

    public static function setValidSearchError($formObj) {
        $formObj->addErrMsg('email', InputConst::EMAIL_ALREADY_REGIST_DB);
        return $formObj;
    }
}