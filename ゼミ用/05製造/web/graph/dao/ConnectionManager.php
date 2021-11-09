<?php

/**
 * DB接続をするクラス
 */
class ConnectionManager {

    private $db;
    private $host = 'mysql:dbname=dkgraph_correlation;host=localhost:3306'; // ローカル
    private $username = 'dkgraph_exit';// ローカル
    // private $host = 'mysql:dbname=dkgraph_correlation;host=mysql1.php.xdomain.ne.jp'; // 本番
    // private $username = 'dkgraph_exit'; // 本番
    private $password = 'g20e38h41AAbf';

    public function __construct() {
        $this->db = new PDO($this->host, $this->username, $this->password);
    }

    public function getDB() {
        return $this->db;
    }
}
