<?php

/**
 * DB接続をするクラス
 */
class ConnectionManager {

    private $db;

    public function __construct() {
        $this->db = new SQLite3("../../db/correlation.db");
    }

    public function getDB() {
        return $this->db;
    }
}
