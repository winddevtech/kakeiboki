<?php
// メール処理クラス
class MailProc {
    // メール送信処理
    // 【引数】宛先Email、タイトル、本文
    public static function sendMail($email, $subject, $body){
        mb_language('ja');
        mb_internal_encoding('UTF-8');
        mb_send_mail($email, $subject, $body);
    }
}
