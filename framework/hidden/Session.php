<?php
/*
 * SESSION変数クラス
 */
class Session {
    private $_values = array();
    private static $instance;
    private function __construct() {
        session_start();
        $this->setValues();
    }
    
    // 指定キーのパラメータを取得
    public function get($key = null) {
        $ret = null;
        if (null == $key) {
            $ret = $this->_values;
        } else if ($this->has($key)) {
            $ret = $this->_values[$key];
        }
        return $ret;
    }
    
    // 指定のキーが存在するか確認
    public function has($key) {
        if (! array_key_exists($key, $this->_values)) {
            return false;
        }
        return true;
    }
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function setValues() {
        foreach ($_SESSION as $key => $value) {
            $this->_values[$key] = $value;
        }
    }
    
    // Session変数取得
    public function getSession($key = null) {
        if (null == $key) {
            return $this->get();
        }
        if (! $this->has($key)) {
            return null;
        }
        return $this->get($key);
    }
    public function setSession($key, $value) {
        $_SESSION[$key] = $value;
        $this->_values[$key] = $value;
    }
    
    // セッション変数削除
    public function remove($key) {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }
    
    // セッションIDを生成しなおす
    public function regenerateId() {
        session_regenerate_id(true);
    }
    
    // セッション変数クリア
    public function clear() {
        $_SESSION = array ();
    }
    
    // セッションを破棄
    public function destroy(){
        session_destroy();
    }
    
    public function getSessionName() {
        return session_name();
    }
    
    public function getSessionId() {
        return session_id();
    }
}
