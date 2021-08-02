<?php
require_once dirname(__FILE__) . '/ConnectionManager.php';
require_once dirname(__FILE__) . '/../dto/CorUser.php';

class CorUserDao {

    /**
     * 最大値のユーザIDを取得します
     */
    public function selectMaxId() {

        // db接続
        $connectionManager = new ConnectionManager();

        // sql作成
        $sql = "SELECT Max(user_id) FROM cor_user;";

        // データベースへの接続を表すPDOインスタンスを生成
        $pdo = $connectionManager->getDB();

        // プリペアドステートメントを作成
        $stmt = $pdo->prepare($sql);

        //  sql実行
        $stmt->execute();

        // sql結果を配列に格納
        $result = $stmt->fetchAll();

        return $result['user_id'];
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

        $corUserList = array();
        foreach ($stmt->fetchAll() as $row) {
            $corUser = new CorUser();

            $corUser->setUserId($row['user_id']);
            $corUser->setUserName($row['user_name']);
            $corUser->setPassword($row['password']);
            $corUser->setVersion($row['version']);

            array_push($corUserList, $corUser);
        }

        return $corUserList;
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

        // 実行結果を
        $corUser = new CorUser();
        $corUser->setUserId($result['user_id']);
        $corUser->setUserName($result['user_name']);
        $corUser->setPassword($result['password']);
        $corUser->setVersion($result['version']);

        return $corUser;
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
