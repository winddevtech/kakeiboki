<?php
require_once 'com/MainController.php';
class DownloadController extends MainController  {
    public function __construct() {
        parent::__construct();
    }
    
    public function preAction(){
        if (! $this->session->has('login_user_obj')) {
            Redirect::locationTop();
        }
    }

    /**
     * インポート用テンプレートファイルダウンロード
     */
    public function indexAction() {
        if ($this->request->getQuery('id') == 1){
            $file_fullpath = dirname(__FILE__) . '/../download/template.csv';
            
            // ファイルの存在確認 
            if (!file_exists($file_fullpath)) {
                die('Error: File('.$file_fullpath.') does not exist');
            }
            
            // オープンできるか確認
            $fp = fopen($file_fullpath, 'r');
            if (! $fp) {
                die('Error: Cannot open the file('.$file_fullpath.')');
            }
            fclose($fp);
            
            // ファイルサイズの確認
            $content_length = filesize($file_fullpath);
            if ($content_length == 0) {
                die('Error: File size is 0.('.$file_fullpath.')');
            }
            
            // レスポンスヘッダー（MIMEタイプ）の設定
            header('Content-Type: application/octet-stream');
            header('Content-Length: '.$content_length);
            header('Content-Disposition: attachment; filename=template.csv');
            
            // ファイルを読んで出力
            if (! readfile($file_fullpath)) {
                die('Cannot read the file template.csv');
            }
        }
    }
}