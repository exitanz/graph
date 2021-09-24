<?php
require_once dirname(__FILE__) . '/ConnectionManager.php';

class CorUserDao {

    /**
     * 最大値のユーザIDを取得します
     */
    public function selectMaxId() {

        // db接続
        $connectionManager = new ConnectionManager();

        // sql作成
        $sql = "SELECT Max(user_id) AS user_id FROM cor_user;";

        // データベースへの接続を表すPDOインスタンスを生成
        $pdo = $connectionManager->getDB();

        // プリペアドステートメントを作成
        $stmt = $pdo->prepare($sql);

        //  sql実行
        $stmt->execute();

        // sql結果を配列に格納
        $result = $stmt->fetchAll();

        return $result[0]['user_id'];
    }

    /**
     * ユーザ情報を取得します
     */
    public function selectAll() {

        // db接続
        $connectionManager = new ConnectionManager();

        // sql作成
        $sql = "SELECT * FROM cor_user;";

        // データベースへの接続を表すPDOインスタンスを生成
        $pdo = $connectionManager->getDB();

        // プリペアドステートメントを作成
        $stmt = $pdo->prepare($sql);

        //  sql実行
        $stmt->execute();

        $dtoList = array();
        foreach ($stmt->fetchAll() as $row) {
            $dto = array(
                "user_id" => $row['user_id'],
                "user_name" => $row['user_name'],
                "password" => $row['password'],
                "version" => $row['version']
            );
            array_push($dtoList, $dto);
        }

        return $dtoList;
    }

    /**
     * ユーザIDをキーにユーザ情報を取得します
     */
    public function selectByUserId($userId) {

        // sql作成
        $sql = "SELECT user_id, user_name, password, version FROM cor_user WHERE user_id = ?;";

        // db接続
        $connectionManager = new ConnectionManager();

        // プリペアドステートメントを作成
        $stmt = $connectionManager->getDB()->prepare($sql);

        // プレースホルダと変数をバインド
        $stmt->bindParam(1, $userId);

        //  sql実行
        $stmt->execute();

        // sql結果を配列に格納
        $result = $stmt->fetchAll();
        
        // ユーザ情報
        $dto = array();

        if(!empty($result)){
            // 実行結果を格納
            $dto = array(
                "user_id" => $result[0]['user_id'],
                "user_name" => $result[0]['user_name'],
                "password" => $result[0]['password'],
                "version" => $result[0]['version']
            );
        }

        return $dto;
    }

    /**
     * ユーザ情報を登録します
     */
    public function insert($userId, $userName, $password, $version = 0) {

        // sql作成
        $sql = "INSERT INTO cor_user (user_id, user_name, password, version) VALUES (?, ?, ?, ?);";

        // db接続
        $connectionManager = new ConnectionManager();

        // プリペアドステートメントを作成
        $stmt = $connectionManager->getDB()->prepare($sql);

        // プレースホルダと変数をバインド
        $stmt->bindParam(1, $userId);
        $stmt->bindParam(2, $userName);
        $stmt->bindParam(3, $password);
        $stmt->bindParam(4, $version);

        //  sql実行
        $stmt->execute();
    }

    /**
     * ユーザ情報を更新します
     */
    public function update($userId, $userName, $password, $version = 0) {

        // sql作成
        $sql = "UPDATE cor_user SET ";
        if ($userName != null) {
            $sql .= "user_name=:user_name, ";
        }
        if ($password != null) {
            $sql .= "password=:password, ";
        }
        $sql .= "version=:version WHERE user_id=:user_id;";

        // db接続
        $connectionManager = new ConnectionManager();

        // プリペアドステートメントを作成
        $stmt = $connectionManager->getDB()->prepare($sql);

        // プレースホルダと変数をバインド
        if ($userName != null) {
            $stmt->bindParam(':user_name', $userName);
        }
        if ($password != null) {
            $stmt->bindParam(':password', $password);
        }
        $stmt->bindParam(':version', $version + 1);
        $stmt->bindParam(':user_id', $userId);

        //  sql実行
        $stmt->execute();
    }

    /**
     * ユーザ情報を削除します
     */
    public function delete($userId) {

        // sql作成
        $sql = "DELETE FROM cor_user WHERE user_id = :user_id;";

        // db接続
        $connectionManager = new ConnectionManager();

        // プリペアドステートメントを作成
        $stmt = $connectionManager->getDB()->prepare($sql);

        // プレースホルダと変数をバインド
        $stmt->bindParam(':user_id', $userId);

        //  sql実行
        $stmt->execute();
    }
}
