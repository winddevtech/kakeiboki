<?php
require_once 'hidden/Database.php';
class ModelBase {
    protected static $db_obj;

    public function __construct() {
    }

    private static function connectDB(){
        if (self::$db_obj == null) {
            self::$db_obj = Database::getInstance();
        }
    }

    //データ挿入
    public static function insert($sql, $query_arg){
        self::connectDB();
        return self::$db_obj->insert($sql,$query_arg);
    }

    // クエリ結果を取得（1件）
    public static function query($sql, array $query_arg = array()) {
        self::connectDB();
        return self::$db_obj->query($sql, $query_arg);
    }

    // クエリ結果を取得（複数）
    public static function queryAll($sql, array $query_arg = array()) {
        self::connectDB();
        return self::$db_obj->queryAll($sql, $query_arg);
    }

    // クエリ結果を取得（行カウント）
    public static function queryCount($sql, $query_arg = array()) {
        self::connectDB();
        return self::$db_obj->queryCount($sql, $query_arg);
    }

    //データ更新
    public static function update($sql,$query_arg){
        self::connectDB();
        return self::$db_obj->update($sql,$query_arg);
    }

    //データ削除
    public static function delete($sql, $query_arg = null) {
        self::connectDB();
        return self::$db_obj->delete($sql,$query_arg);
    }
}
