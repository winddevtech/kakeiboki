<?php
require_once dirname(__FILE__) . '/../Util.php';

// 基礎データベースクラス
class Database {
    private static $instance; // このクラスのインスタンス
    private $pdo; // データベースへのPDO接続実行obj

    // DB接続
    private function __construct() {
        $param = 'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST;
        try {
            $this->pdo = new PDO($param, DB_USER, DB_PASS);
            $this->pdo->query('set names utf8;');
        } catch (PDOException $e) {
            Util::logging(basename(__FILE__), __LINE__, $e->getMessage());
        } catch (Exception $e) {
            Util::logging(basename(__FILE__), __LINE__, $e->getMessage());
        }
    }

    /**
     * インスタンスを取得する
     */
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // $pdo変数を削除する
    public function __destruct() {
        unset($this->pdo);
    }
    public function getPdo() {
        return $this->pdo;
    }

    //最後に登録したテーブルの管理IDを取得する
    public function getLastInsertId(){
        return $this->pdo->lastInsertId('id');
    }

    // クエリ結果を取得
    public function query($sql, $params = array()) {
        $stmt = $this->pdo->prepare($sql);
        if ($params != null) {
            foreach ($params as $key => $val) {
                $stmt->bindValue($key, $val[0], $val[1]);
            }
        }
        $stmt->execute();
        $row = $stmt->fetch();

        return $row;
    }
    // クエリ結果を取得（複数）
    public function queryAll($sql, $params = array()) {
        $stmt = $this->pdo->prepare($sql);
        if ($params != null) {
            foreach ($params as $key => $val) {
                $stmt->bindValue($key, $val[0], $val[1]);
            }
        }

        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $rows;
    }

    // クエリ結果を取得（行カウント）
    public function queryCount($sql, $params = array()) {
        $stmt = $this->pdo->prepare($sql);
        if ($params != null) {
            foreach ($params as $key => $val) {
                $stmt->bindValue($key, $val[0], $val[1]);
            }
        }
        $stmt->execute();
        $row = $stmt->fetchColumn();

        return $row;
    }

    // INSERTを実行
    public function insert($sql, $params = array()) {
        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val[0], $val[1]);
        }
        $result = $stmt->execute();

        return $result;
    }

    // UPDATEを実行
    public function update($sql, $params = array()) {
        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val[0], $val[1]);
        }
        $result = $stmt->execute();

        return $result;
    }

    // DELETEを実行
    public function delete($sql, $params = null) {
        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val[0], $val[1]);
        }
        $result_flg = $stmt->execute();

        return $result_flg;
    }
    public function setDefaultTableName() {
        $className = get_class($this);
        $len = strlen($className);
        $tableName = '';
        for ($i = 0; $i < $len; $i ++) {
            $char = substr($className, $i, 1);
            $lower = strtolower($char);
            if ($i > 0 && $char != $lower) {
                $tableName .= '_';
            }
            $tableName .= $lower;
        }
        $this->name = $tableName;
    }
}