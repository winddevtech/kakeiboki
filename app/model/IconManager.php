<?php
require_once 'dbmanager/UserDB.php';

//アイコン管理クラス
class IconManager {
    //アイコン画像文字列をblob形式にする
    public static function createIconOfBlob($img_str, $icon_name) {
        $canvas = preg_replace('/data:[^,]+,/i','',$img_str);
        $canvas = base64_decode($canvas);
        $img = imagecreatefromstring($canvas);

        if ($img) {
            imagesavealpha($img, true);
            imagepng($img ,$icon_name);
            $img = fopen($icon_name, 'rb');
        } else {
            $img = '';
        }

        return $img;
    }

    //ローカルに生成されたアイコン画像を削除する
    public static function deleteIconOfLocal($img, $icon_name){
        if ($img != ''){
            fclose($img);
            unlink($icon_name);
        }
    }

    //アイコンが設定されていなければ初期アイコンを表示する
    public static function getDisplayIcon($iconImage){
        return ($iconImage == '') ? InputConst::ICON_DEFAULT_PATH : $iconImage;
    }

    //アイコンが設定されていなければ初期アイコンを表示する
    public static function pullIconFromDB($iconImage){
        return ($iconImage == '') ? InputConst::ICON_DEFAULT_PATH : 'data:image/png;base64,' . base64_encode($iconImage);
    }
}