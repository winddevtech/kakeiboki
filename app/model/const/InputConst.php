<?php
// 入力エラー定数
class InputConst {
    // ユーザー情報
    const USER_NAME_MAX_LENGTH = 15;
    const PASSWORD_MAX_LENGTH = 30;
    const PASSWORD_MIN_LENGTH = 8;
    const EMAIL_MAX_LENGTH = 100;
    const USER_NAME_NOT_INPUT = 'ユーザー名を入力して下さい。';
    const USER_NAME_LENGTH_OVER = '全角半角合わせて15文字以内で入力して下さい。';
    const USER_NAME_NOT_SELECT = 'ユーザー名を選択して下さい。';
    const PASSWORD_NOT_INPUT = 'パスワードを入力して下さい。';
    const PASSWORD_LENGTH_RANGE_OVER = '英数字8文字以上30文字以内で入力して下さい。';
    const PASSWORD_NOT_AGREEMENT = 'パスワードと確認用パスワードが一致しません。';
    const PASSWORD_NOT_LOGIN = 'パスワードが正しくありません。';
    const EMAIL_NOT_INPUT = 'Emailを入力して下さい。';
    const EMAIL_LENGTH_OVER = '100文字以内で入力して下さい。';
    const EMAIL_FORMAT_ERROR = 'Email形式で入力して下さい。';
    const EMAIL_ALREADY_REGIST_DB = 'このEmailは既に登録されています。';
    const EMAIL_NOT_REGIST_DB = 'このEmailは登録されていません。';
    const MULTIPLE_LOGIN_ERROR = '既に別ブラウザ・PCでログインされています。';
    const DISP_COUNT_ERROR = '不正な表示件数が設定されています。';
    const ICON_DEFAULT_PATH = APP_DIR_NAME . 'app/assets/images/default.png';
    const ICON_FORMAT_ERROR = '異常なアイコン形式が設定されています。';
    public static $display_count_list = array (
            '1' => '10', '2' => '20', '3' => '25', '4' => '30', '5' => '50', '6' => '100');

    //お問い合わせ情報
    const CONTEXT_MAX_LENGTH = 1000;
    const CATEGORY_ID_NOT_SELECT = 'カテゴリーを選択して下さい。';
    const CATEGORY_ID_ERROR = '不正なカテゴリーが設定されています。';
    const CONTEXT_NOT_INPUT = '本文を入力して下さい。';
    const CONTEXT_LENGTH_OVER = '本文は1000文字以内で入力して下さい。';
    public static $category_select_list = array (
            '' => 'カテゴリーを選択してください', '1' => '家計簿記の利用方法', '2' => 'エラーについて', '3' => 'その他');
    public static $category_white_list = array (
             '1' => '家計簿記の利用方法', '2' => 'エラーについて', '3' => 'その他');

    //家計簿情報
    const CREATION_DATE_NOT_INPUT = '仕訳発生日を入力して下さい。';
    const CREATION_DATE_FORMAT_ERROR = '仕訳発生日はyyyy/mm/dd形式で設定して下さい。';
    const CREATION_DATE_NOT_DAY = '仕訳発生日は暦上の日付を設定して下さい。';
    const USE_ITEM_ID_NOT_SELECT = '用途を選択して下さい。';
    const USE_ITEM_ID_ERROR = '不正な用途が設定されています。';
    const DEBIT_ID_ERROR = '不正な借方が設定されています。';
    const CREDIT_ID_ERROR = '不正な貸方が設定されています。';
    const PRICE_NOT_INPUT = '金額を入力して下さい。';
    const PRICE_FORMAT_ERROR = '金額は数値形式で入力して下さい。';
    const PRICE_MAX_SIZE = 10000000; // 今回はDBに登録できる金額は1千万までとする
    const PRICE_ZERO_UNDER = '金額は0以上の数値を入力してください。';
    const PRICE_MAX_NUMBER_OVER = '金額は1千万まで入力可能です。';
    const SUMMARY_MAX_NUMBER_OVER = '摘要は30文字以内で入力して下さい。';
    const SUMMARY_MAX_LENGTH = 30;

    //日付フォーマット
    const FORMAT_DATE_YM = '/^([1-9][0-9]{3})\/(0*[1-9]{1}|1[0-2]{1})$/';
    const FORMAT_DATE_YM_DD = '/([1-9][0-9]{3})\/(0*[1-9]{1}|1[0-2]{1})\/(0*[1-9]{1}|[1-2]{1}[0-9]{1}|3[0-1]{1})/';

    //インポートファイル
    const IMPORT_FILE_MAX_SIZE = 1048576;
    const IMPORT_FILE_NOT_SET = 'インポートするCSVファイルを選択して下さい。';
    const IMPORT_FILE_OTHER_FORMAT = 'インポートするファイルはCSV形式を選択して下さい。';
    const IMPORT_FILE_LENGTH_OVER = 'インポートするファイルサイズは1MB以内にして下さい。';

    public static $use_id_white_list = array (
            '1' => '給与振込', '18' => '給与以外の利益が発生した', '21' => '住宅ローンの借り入れ',
            '2' => '銀行口座からの引き出し（手数料なし）', '3' => '銀行口座からの引き出し（手数料あり）', '4' => '銀行口座へ預金',
            '5' => '食費', '6' => '住居費', '7' => '水道光熱費', '8' => '交通費', '9' => '医療・健康費',
            '10' => '被服費', '11' => '教育費', '12' => '趣味・教養・娯楽費', '13' => '交際費', '14' => '通信費',
            '15' => '車両費', '16' => '税金・社会保険料の当座預金支払', '17' => '税金・社会保険料の現金支払',
            '19' => '項目にはない費用が発生した', '20' => '新聞・書籍代', '22' => '住宅ローンの返済'
    );

    public static $use_item_select_list = array (
            '' => array('' => 'カテゴリーを選択してください'),
            '収入' => array('1' => '給与振込', '18' => '給与以外の利益が発生した', '21' => '住宅ローンの借り入れ'),
            '振替' => array('2' => '銀行口座からの引き出し（手数料なし）', '3' => '銀行口座からの引き出し（手数料あり）', '4' => '銀行口座へ預金'),
            '支出' => array('5' => '食費', '6' => '住居費', '7' => '水道光熱費', '8' => '交通費', '9' => '医療・健康費',
            '10' => '被服費', '11' => '教育費', '12' => '趣味・教養・娯楽費', '13' => '交際費', '14' => '通信費',
            '15' => '車両費', '16' => '税金・社会保険料の当座預金支払', '17' => '税金・社会保険料の現金支払',
            '19' => '項目にはない費用が発生した', '20' => '新聞・書籍代', '22' => '住宅ローンの返済')
    );

    public static $journal_subject_id_white_list = array (
            '1' => '食費', '2' => '住居費', '3' => '水道光熱費', '4' => '交通費', '5' => '医療・健康費',
            '6' => '被服費', '7' => '教育費', '8' => '趣味・教養・娯楽費', '9' => '交際費', '10' => '通信費',
            '11' => '車両費', '12' => '税金・社会保険料', '13' => '新聞・書籍代', '14' => '特別損失',
            '15' => '手数料', '16' => '現金', '17' => '当座預金', '18' => '住宅ローン', '19' => '給料', '20' => '特別利益'
    );

    public static $journal_category_white_list = array (
            '1' => '費用', '2' => '資産', '3' => '負債', '4' => '収益'
    );
}