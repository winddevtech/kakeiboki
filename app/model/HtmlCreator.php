<?php
require_once 'const/InputConst.php';

//html作成クラス
class HtmlCreator {

    //表示件数を選択するプルダウンhtml文字列を生成する
    public static function createDisplayCount($displayCount) {

        $selectHtmlStr = Util::arrayToSelect(
                array ('name' => 'display_count','id' => 'display_count', 'class' => 'ctl-select display_count'),
                InputConst::$display_count_list,
                $displayCount);

        return $selectHtmlStr;
    }

    //カテゴリーを選択するプルダウンhtml文字列を生成する
    public static function createCategoryId($categoryId) {
        $categoryIdHtmlStr = Util::arrayToSelect(
                array ('name' => 'category_id','id' => 'js-category_id', 'class' => 'ctl-select'),
                InputConst::$category_select_list,
                $categoryId);

        return $categoryIdHtmlStr;
    }

    //用途選択のプルダウンhtml文字列を生成する
    public static function createUseItemSelect($useItemId) {
        $useItemSelectHtmlStr = Util::arrayToSelectGroup(
                array ('name' => 'use_item_id','id' => 'use_item_id', 'class' => 'ctl-select form-item-large'),
                InputConst::$use_item_select_list,
                $useItemId);

        return $useItemSelectHtmlStr;
    }
}