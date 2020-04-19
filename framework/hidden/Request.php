<?php
require_once 'QueryString.php';
require_once 'Post.php';
require_once 'UrlParameter.php';
require_once 'Files.php';
class Request {
    // POSTパラメータ
    private $post;
    // GETパラメータ
    private $query;
    // URLパラメータ
    private $param;
    // Filesパラメータ
    private $files;
    
    public function __construct() {
        // POSTパラメータはあるか
        if (isset($_POST)) {
            $this->post = new Post();
        }
        // GETパラメータはあるか
        if (isset($_GET)) {
            $this->query = new QueryString();
        }
        
        // Filesパラメータはあるか
        if (isset($_FILES)) {
            $this->files = new Files();
        }
        
        // $this->param = new UrlParameter();
    }
    
    // POST変数取得
    public function getPost($key = null) {
        if (null == $key) {
            return $this->post->get();
        }
        if (! $this->post->has($key)) {
            return null;
        }
        return $this->post->get($key);
    }
    
    // GET変数取得
    public function getQuery($key = null) {
        if (null == $key) {
            return $this->query->get();
        }
        if (! $this->query->has($key)) {
            return null;
        }
        return $this->query->get($key);
    }
    
    // URLパラメーター取得
    public function getParam($key = null) {
        if (null == $key) {
            return $this->param->get();
        }
        if (! $this->param->has($key)) {
            return null;
        }
        return $this->param->get($key);
    }
    
    // Files変数取得
    public function getFiles($key = null) {
        if (null == $key) {
            return $this->files->get();
        }
        if (! $this->files->has($key)) {
            return null;
        }
        return $this->files->get($key);
    }
    
    //全角スペースを半角にする
    public static function trimReqSpaceHerf($value) {
        return trim(mb_convert_kana($value, 's', 'UTF-8'));
    }
    
    //先頭・末尾のスペースを取り除く
    public static function trimReqTrimSpace($value) {
        return trim($value);
    }
    
    //全角スペースを半角にする
    public static function initReqSpaceHerf($value, $false = '') {
        return isset($value) ? trim(mb_convert_kana($value, 's', 'UTF-8')) : $false;
    }
    //先頭・末尾のスペースを取り除く
    public static function initReqTrimSpace($value) {
        return isset($value) ? trim($value) : '';
    }
}