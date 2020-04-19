<?php
// 基礎チェッククラス
class Validation {

    private static function valInput($value){
        return ($value != '') ? true : false;
    }
    /*
     * 文字数チェック（全角半角不問）
     * 【引数】長さを確認する文字列、使用可能な最大文字数
     * 【戻り値】異常あり:false、異常なし:true
     */
    private static function strLen($str, $maxLength) {
        // 文字列は使用可能な最大文字数を超えているか
        if (mb_strlen(mb_convert_encoding($str, 'SJIS', 'UTF-8'), 'SJIS') > $maxLength) {
            return false;
        }

        return true;
    }

    /*
     * 文字列の長さチェック（半角のみ使用可）
     * 【引数】長さを確認する文字列、使用可能な最大文字数
     * 【戻り値】異常あり:false、異常なし:true
     */
    private static function strLenBite($str, $maxLength) {
        // 文字列は使用可能な最大文字数を超えているか
        if (strlen(mb_convert_encoding($str, 'SJIS', 'UTF-8')) > $maxLength) {
            return false;
        }

        return true;
    }

    // 文字列の半角文字チェック（半角英数字記号のみ使用可）
    // 【引数】確認する文字列
    // 【戻り値】異常あり:false、異常なし:true
    private static function strHankaku($str) {
        // 全角文字が混ざっているか
        if (! preg_match('/^[a-zA-Z0-9.-\/:-@\[-`\{-\~]+$/', $str)) {
            return false;
        }

        return true;
    }

    // Email形式チェック
    // 【引数】確認するEmail
    // 【戻り値】異常あり:false、異常なし:true
    private static function emailFormat($email) {
        // Emailの形式に問題があるか
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }

    // 文字列の長さチェック（最少・最大範囲指定）
    // 【引数】長さを確認する文字列、使用可能な最少文字数、使用可能な最大文字数
    // 【戻り値】異常あり:false、異常なし:true
    private static function strLenRangeBite($str, $minLength, $maxLength) {
        // 文字列は使用可能な最少文字数・最大文字数を超えているか
        if (strlen(mb_convert_encoding($str, 'SJIS', 'UTF-8')) < $minLength or $maxLength < strlen(mb_convert_encoding($str, 'SJIS', 'UTF-8'))) {
            return false;
        }

        return true;
    }

    // 文字列を比較する
    // 【引数】比較する文字列1、比較する文字列2
    // 【戻り値】不一致:false、一致:true
    private static function compareToStr($str1, $str2) {
        // 文字列は不一致か
        if (strcmp($str1, $str2) !== 0) {
            return false;
        }

        return true;
    }

    /*
     * DBに登録できるint型データの大きさを確認する
     * 【引数】int型の数値
     * 【戻り値】異常あり:false、異常なし:true
     */
    private static function checkIntTypeData($data, $max_size) {
        if ($data > $max_size) {
            return false;
        }

        return true;
    }

    // ソート条件（並び順）をホワイトリストで照合する
    private static function orderWhitelist($orderCommand) {
        $order_whitelist = array ('asc' => 'asc', 'desc' => 'desc');
        $order_safe = (isset($order_whitelist[$orderCommand])) ? $order_whitelist[$orderCommand] : $order_whitelist['asc'];

        return $order_safe;
    }

    // 日付形式チェック
    // 【引数】日付（yyyy/mm/dd形式）
    // 【戻り値】異常なし：true、異常あり：false
    private static function dateFormat($date) {
        $explode_limit = 3; // データ文字を区切り文字で分割する数

        // 「/」を「-」にして区切り文字「-」で3つに分解し、年・月・日をそれぞれ取得する
        $date_parts = explode('-', str_replace('/', '-', $date), $explode_limit);
        // 正当な日付か
        if (! checkdate($date_parts[1], $date_parts[2], $date_parts[0])) {
            return false;
        }

        return true;
    }

    //データが日付形式をチェックする
    private static function datetimeFormat($date, $reg_str = ''){
        //正規表現は未設定か
        if ($reg_str == '' || ! isset($reg_str)){
            // yyyy/mm/dd形式にする
            $reg_str = '/([1-9][0-9]{3})\/(0*[1-9]{1}|1[0-2]{1})\/(0*[1-9]{1}|[1-2]{1}[0-9]{1}|3[0-1]{1})/';
        }

        if (! preg_match($reg_str, $date)) {
            return false;
        }
        return true;
    }

    // アイコンチェック
    private static function iconFormat($icon_base64_str) {
        if (! preg_match('/data:image\/(png|jpeg|jpg|gif);base64,.+/i', $icon_base64_str)) {
            return false;
        }
        return true;
    }

    //数値か
    private static function isNumeric($value){
        if (! is_numeric($value)) {
            return false;
        }
        return true;
    }

    //数値は0以上か
    private static function isMinNumeric($value){
        if ($value < 0) {
            return false;
        }
        return true;
    }

    //数値はmaxNum以下か
    private static function isMaxNumeric($value, $maxSize){
        if ($maxSize < $value) {
            return false;
        }
        return true;
    }

    private static function cmdSize($value, $command, $maxLength){
        $isErrFlg = null;
        switch ($command) {
            case 'BITE':
                $isErrFlg = self::strLenBite($value, $maxLength);
                break;
            case 'ALL':
                $isErrFlg = self::strLen($value, $maxLength);
                break;
            default:
                break;
        }
        return $isErrFlg;
    }
    private static function cmdFormat($value, $command){
        $isErrFlg = null;
        $maxLength = 0;
        switch ($command) {
            case 'NUMBER':
                $isErrFlg = self::strLenBite($value, $maxLength);
                break;
            case 'DATE':
                $isErrFlg = self::strLen($value, $maxLength);
                break;
            case 'EMAIL':
                $isErrFlg = self::emailFormat($value);
                break;
            default:
                break;
        }
        return $isErrFlg;
    }

    public static function dispatch($value, $validate) {
        $errMsg = '';
        foreach ($validate as $key => $val) {
            $isErrFlg = false;
            switch ($key) {
                case 'require':
                    $errMsg = $validate[$key];
                    $isErrFlg = self::valInput($value);
                    break;
                case 'format_email':
                    $errMsg = $validate[$key];
                    $isErrFlg = self::emailFormat($value);
                    break;
                case 'format_date':
                    $errMsg = $validate[$key];
                    $isErrFlg = self::datetimeFormat($value);
                    break;
                case 'is_date':
                    $errMsg = $validate[$key];
                    $isErrFlg = self::dateFormat($value);
                    break;
                case 'format_number':
                    $errMsg = $validate[$key];
                    $isErrFlg = self::isNumeric($value);
                     break;
                case 'is_min_number':
                    $errMsg = $validate[$key];
                    $isErrFlg = self::isMinNumeric($value);
                    break;
                case 'is_max_number':
                    $errMsg = $validate[$key][1];
                    $isErrFlg = self::isMaxNumeric($value, $validate[$key][0]);
                    break;
                case 'format_icon':
                    $errMsg = $validate[$key];
                    $isErrFlg = self::iconFormat($value);
                    break;
                case 'format':
                    $errMsg = $validate[$key][1][0];
                    $isErrFlg = self::cmdFormat($value, $validate[$key][0]);
                    break;
                case 'size':
                    $errMsg = $validate[$key][2];
                    $isErrFlg = self::cmdSize($value, $validate[$key][0], $validate[$key][1]);
                    break;
                case 'betweenBite':
                    $errMsg = $validate[$key][0];
                    $isErrFlg = self::strLenRangeBite($value, $validate[$key][1], $validate[$key][2]);
                    break;
                case 'compare':
                    $errMsg = $validate[$key][0];
                    $isErrFlg = self::compareToStr($value, $validate[$key][1]);
                    break;
                default:
                    break;
            }
            if (!$isErrFlg) {
                break;
            }
        }

        if (!$isErrFlg) {
            return $errMsg;
        }
        return '';
    }

    public static function dispatchNonMsg($value, $validate) {
        $isResultErr = true;
        foreach ($validate as $key => $val) {
            $isErrFlg = false;
            switch ($key) {
                case 'require':
                    $isErrFlg = self::valInput($value);
                    break;
                case 'format_email':
                    $isErrFlg = self::emailFormat($value);
                    break;
                case 'format_date':
                    $isErrFlg = self::datetimeFormat($value, $validate[$key][0]);
                    break;
                case 'is_date':
                    $isErrFlg = self::dateFormat($value);
                    break;
                case 'format_number':
                    $isErrFlg = self::isNumeric($value);
                    break;
                case 'is_min_number':
                    $isErrFlg = self::isMinNumeric($value);
                    break;
                case 'is_max_number':
                    $isErrFlg = self::isMaxNumeric($value, $validate[$key][0]);
                    break;
                case 'format_icon':
                    $isErrFlg = self::iconFormat($value);
                    break;
                case 'format':
                    $isErrFlg = self::cmdFormat($value, $validate[$key][0]);
                    break;
                case 'size':
                    $isErrFlg = self::cmdSize($value, $validate[$key][0], $validate[$key][1]);
                    break;
                case 'betweenBite':
                    $isErrFlg = self::strLenRangeBite($value, $validate[$key][1], $validate[$key][2]);
                    break;
                case 'compare':
                    $isErrFlg = self::compareToStr($value, $validate[$key][1]);
                    break;
                default:
                    break;
            }
            if (! $isErrFlg) {
                $isResultErr = false;
                break;
            }
        }

        return $isResultErr;
    }
}

