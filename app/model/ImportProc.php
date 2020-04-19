<?php
require_once 'const/InputConst.php';
require_once 'detail/ImportData.php';
require_once 'com/MainProcModel.php';
// インポートファイル操作クラス
class ImportProc extends MainProcModel {

    //バリデーション
    public static function valid($formObj){
        return parent::validForm('Import', $formObj);
    }

    // インポートデータチェック処理
    public static function validData($import_detail_obj) {
        $file = $import_detail_obj->getFile(); //インポートファイル
        $header_row_flg = $import_detail_obj->getHeaderFlg(); //ヘッダー行有無フラグ
        $data_array = array (); //チェック対象データを格納する配列
        $ok_data_array = array (); // データ確認で登録可能なデータを格納する
        $ok_data_count = 0;  //データ登録可能件数
        $ng_data_count = 0;  //データ登録不可件数

        //データをUTF-8文字列として取得
        $import_data_list = file_get_contents($file['tmp_name']);
        $import_data_list = mb_convert_encoding($import_data_list, 'UTF-8', 'sjis-win');

        // 取得した文字列データを再度CSVファイルとして書き出す
        $temp_data_list = tmpfile();
        fwrite($temp_data_list, $import_data_list);
        rewind($temp_data_list);

        // CSVファイルを配列に書き出す
        while (($data = fgetcsv($temp_data_list, 0, ',')) !== false) {
            // ヘッダー行有無フラグはtrueか
            if ($header_row_flg) {
                $header_row_flg = false;
                continue;
            }
            $data_array[] = $data;
        }

        // CSVファイルを閉じる
        fclose($temp_data_list);

        require_once dirname(__FILE__) . '/../../framework/Validation.php';
        require_once 'validator/ValidImport.php';

        //データチェック
        foreach ($data_array as $row) {
            $creation_date = trim(mb_convert_kana($row[0], 's', 'UTF-8'));
            $use_item_id = trim(mb_convert_kana($row[1], 's', 'UTF-8'));
            $price = trim(mb_convert_kana($row[2], 's', 'UTF-8'));
            $summary = trim(mb_convert_kana($row[3], 's', 'UTF-8'));

            // ファイルに格納されている家計簿情報をチェックする
            $result_flg = ValidImport::rowData($creation_date, $use_item_id, $price, $summary);
            if (! $result_flg) {
                $ng_data_count ++;
                continue;
            }

            array_push($ok_data_array, array ($creation_date, $use_item_id, $price, $summary));
            $ok_data_count ++;
        }

        //データチェック結果を設定する
        $import_detail_obj->setOkDataArray($ok_data_array);
        $import_detail_obj->setOkDataCount($ok_data_count);
        $import_detail_obj->setNgDataCount($ng_data_count);

        return $import_detail_obj;
    }


    // DBに新規一括登録
    public static function insertAll($importDetailObj, $userId) {
        require_once 'dbmanager/BudgetDB.php';

        $isExecute = BudgetDB::insertAll($importDetailObj, $userId);

        return $isExecute;
    }

    public static function transaction($userId, $actionName) {
        return parent::transaction($userId, $actionName);
    }
}