<?php
// 一纏めにできない関数をまとめたクラス
class Util {
    // 配列からプルダウンメニューの<option></option>タグを生成する
    // 【引数】値を入れた配列、selectedのindex
    // 【戻り値】プルダウンメニューの<option></option>タグの文字列
    public static function arrayToSelectOption($srcArray, $selectedIndex = ''){
        foreach ($srcArray as $key => $val) {
            if ($selectedIndex == $key) {
                $selectedText = ' selected=\'selected\'';
            } else {
                $selectedText = '';
            }
            $temphtml .= '<option value=\'' . $key . '\'' . $selectedText . '>' . $val . '</option>' . '\n';
        }
        return $temphtml;
    }

    // 配列からプルダウンメニューを生成する
    /* 引数：属性名配列、値を入れた配列、selectedのindex */
    public static function arrayToSelect($atrArray, $srcArray, $selectedIndex = ''){
        $atrStr = '';
        foreach ($atrArray as $key => $val) {
            $atrStr .= $key . '="' . $val . '" ';
        }

        $temphtml = '<select ' . $atrStr . '>' . "\n";
        foreach ($srcArray as $key => $val) {
            if ($selectedIndex == $key) {
                $selectedText = ' selected="selected"';
            } else {
                $selectedText = '';
            }
            $temphtml .= '<option value="' . $key . '"' . $selectedText . '>' . $val . '</option>' . "\n";
        }
        $temphtml .= '</select>' . "\n";

        return $temphtml;
    }

    // 配列からグループ化したプルダウンメニューを生成する
    public static function arrayToSelectGroup($atrArray, $srcArray, $selectedIndex = ''){
        $atrStr = '';
        foreach ($atrArray as $key => $val) {
            $atrStr .= $key . '="' . $val . '" ';
        }

        $temphtml = '<select ' . $atrStr . '>' . "\n";
        foreach ($srcArray as $key1 => $val1) {
            $temphtml .= '<optgroup label="'.$key1 .'">';

            foreach ($val1 as $key2 => $val2){
                if ($selectedIndex == $key2) {
                    $selectedText = ' selected="selected"';
                } else {
                    $selectedText = '';
                }
                $temphtml .= '<option value="' . $key2 . '"' . $selectedText . '>' . $val2 . '</option>' . "\n";
            }

            $temphtml .= '</optgroup>';
        }
        $temphtml .= '</select>' . "\n";

        return $temphtml;
    }

    //エラーメッセージ表示タグ出力
    public static function errMsgHtml($errmsg){
        return '<span class="help-block">' . $errmsg . '</span>';
    }

    //パスワード文字列生成
    public static function generatePassword(){
        return substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 10); // 10文字生成
    }


    // エラーログ出力
    //【引数】エラー発生したファイル名、エラーが発生した行番号、出力する内容
    public static function logging($filename, $line, $message){
        error_log(date('Y/m/d H:i:s') . ' ' . $message . '[' . $filename . ':' . $line . ']' . PHP_EOL, 3, LOG_FILE);
    }
}
