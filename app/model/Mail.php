<?php
require_once dirname(__FILE__) . '/../../framework/MailProc.php';

// メール送信クラス
class Mail {

    // ユーザー情報登録時
    public static function signup($email, $user_name) {
        $body = $user_name . ' さん' . PHP_EOL . PHP_EOL . '家計簿記へのご登録が完了しました。';
        $body .= PHP_EOL . '今後とも家計簿記をよろしくお願い致します。';
        $body .= PHP_EOL . PHP_EOL . '---------------------------------------------------' . PHP_EOL;
        $body .= '家計簿記のログインはこちらから' . PHP_EOL;
        $body .= 'https://webdiv.sakura.ne.jp/kakeiboki/app/' . PHP_EOL;

        MailProc::sendMail($email, '【家計簿記】利用登録完了', $body);
    }

    // ユーザー情報更新時
    public static function edit($email, $user_name){
        $body = $user_name . ' さん' . PHP_EOL . PHP_EOL . '家計簿記のユーザ情報の変更が完了しました。';
        $body .= PHP_EOL . '今後とも家計簿記をよろしくお願い致します。';
        $body .= PHP_EOL . PHP_EOL . '---------------------------------------------------' . PHP_EOL;
        $body .= '家計簿記のログインはこちらから' . PHP_EOL;
        $body .= 'https://webdiv.sakura.ne.jp/kakeiboki/app/' . PHP_EOL;

        MailProc::sendMail($email, '【家計簿記】ユーザ情報変更完了', $body);
    }

    // 仮パスワード発行時
    public static function auth($email, $user_name, $kari_password){
        $body = $user_name . ' さん' . PHP_EOL . PHP_EOL . '家計簿記の仮パスワードを発行しました。';
        $body .= PHP_EOL . '24時間以内にログインして、パスワードを変更してください。';
        $body .= PHP_EOL . '仮パスワード：' . $kari_password;
        $body .= PHP_EOL . PHP_EOL.'今後とも家計簿記をよろしくお願い致します。';
        $body .= PHP_EOL . PHP_EOL . '---------------------------------------------------' . PHP_EOL;
        $body .= '家計簿記のログインはこちらから' . PHP_EOL;
        $body .= 'https://webdiv.sakura.ne.jp/kakeiboki/app/' . PHP_EOL;

        MailProc::sendMail($email, '【家計簿記】仮パスワード通知', $body);
    }
}