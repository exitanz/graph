<?php

/**
 * DB接続をするクラス
 */
class ConnectionManager {

    private $db;
    private $host = 'pgsql:host=ec2-54-160-35-196.compute-1.amazonaws.com;dbname=d9s2austnk1oq4'; // 本番
    private $username = 'ygcjixssdqexqg';
    private $password = 'edf1e8128c346e33d20d7501e58411ab6164ad1f347f59a0c565d1cd8c97c6f6';

    public function __construct() {
        $this->db = new PDO($this->host, $this->username, $this->password);
    }

    public function getDB() {
        return $this->db;
    }
}
