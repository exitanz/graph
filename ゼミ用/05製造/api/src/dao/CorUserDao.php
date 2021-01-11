<?php
require_once dirname(__FILE__).'/ConnectionManager.php';
require_once dirname(__FILE__).'/../dto/CorUser.php';

class CorUserDao {

    /**
     * 最大値のユーザIDを取得します
     */
    public function selectMax() {

        // sql作成
        $sql = "SELECT Max(user_id) FROM cor_user;";

        // db接続
        $connectionManager = new ConnectionManager();
        $db = $connectionManager->getDB();

        // プリペアドステートメントを作成
        $stmt = $db->prepare($sql);

        //  sql実行
        $result = $stmt->execute();

        // sql結果を配列に格納
        $arr = $result->fetchArray();

        return $arr[0];
    }

    /**
     * ユーザIDをキーにユーザ情報を取得します
     */
    public function selectByUserId($userId) {

        // sql作成
        $sql = "SELECT user_id, user_name, password, version FROM cor_user WHERE user_id = ?;";

        // db接続
        $connectionManager = new ConnectionManager();
        $db = $connectionManager->getDB();

        // プリペアドステートメントを作成
        $stmt = $db->prepare($sql);

        // プレースホルダと変数をバインド
        $stmt->bindParam(1, $userId);

        //  sql実行
        $result = $stmt->execute();

        // sql結果を配列に格納
        $arr = $result->fetchArray();

        // 実行結果を
        $corUser = new CorUser();
        $corUser->setUserId($arr['user_id']);
        $corUser->setUserName($arr['user_name']);
        $corUser->setPassword($arr['password']);
        $corUser->setVersion($arr['version']);

        return $corUser;
    }

    /**
     * ユーザ情報を登録します
     */
    public function insert($userId, $userName, $password, $version = 0) {
        echo ($userId . ',' . $userName . ',' . $password . ',' . $version);

        // sql作成
        $sql = "INSERT INTO cor_user (user_id, user_name, password, version) VALUES (?, ?, ?, ?);";

        // db接続
        $connectionManager = new ConnectionManager();
        $db = $connectionManager->getDB();

        // プリペアドステートメントを作成
        $stmt = $db->prepare($sql);

        // プレースホルダと変数をバインド
        $stmt->bindParam(1, $userId);
        $stmt->bindParam(2, $userName);
        $stmt->bindParam(3, $password);
        $stmt->bindParam(4, $version);

        //  sql実行
        $stmt->execute();
    }
}
