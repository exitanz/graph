<?php

/**
 * DB接続をするクラス
 */
class ConnectionManager {

    private $db;
    private $host = 'mysql:dbname=test;host=localhost:3306';
    private $username = 'test';
    private $password = 'test';

    public function __construct() {
        $this->db = new PDO($this->host, $this->username, $this->password);
    }

    public function getDB() {
        return $this->db;
    }
}
