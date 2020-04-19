<?php
// 定数の定義
define('SERVICE_NAME', '家計簿記'); // タイトル
define('SERVICE_SHORT_NAME', 'kakeiboki'); // タイトルロゴ
define('COPYRIGHT', '&copy; 2017 sample'); // フッターのコピーライト

define('DB_HOST', ''); // ホスト名
define('DB_USER', ''); // ホストのユーザ名
define('DB_PASS', ''); // 接続パスワード
define('DB_NAME', ''); // データベース名

define('DOMAIN_NAME', 'http://localhost'); //ドメイン
define('APP_DIR_NAME', '/kakeiboki/'); //アプリディレクトリ
define('SITE_URL', 'http://localhost/kakeiboki/app/'); //ユーザー向け画面
define('SITE_URL_KANRI', 'http://localhost/kakeiboki/app_ad/');//管理者向け画面

define('COOKIE_NAME', 'KAKEIBOKI'); // Cookie名
define('COOKIE_EFFECT_PATH', '/kakeiboki/'); // Cookieの有効範囲指定

define('LOG_FILE', dirname(__FILE__) . '/../logs/errlog.log'); // ログファイル