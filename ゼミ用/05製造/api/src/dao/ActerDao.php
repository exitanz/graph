<?php
require_once dirname(__FILE__) . '/ConnectionManager.php';

class ActerDao {

    /**
     * 最大値の登場人物IDを取得します
     */
    public function selectMaxId() {

        // db接続
        $connectionManager = new ConnectionManager();

        // sql作成
        $sql = "SELECT Max(acter_id) AS acter_id FROM acter;";

        // データベースへの接続を表すPDOインスタンスを生成
        $pdo = $connectionManager->getDB();

        // プリペアドステートメントを作成
        $stmt = $pdo->prepare($sql);

        //  sql実行
        $stmt->execute();

        // sql結果を配列に格納
        $result = $stmt->fetchAll();

        return $result[0]['acter_id'];
    }

    /**
     * 登場人物情報を取得します
     */
    public function selectAll($acterId, $acterName, $acterInfo, $acterImg, $opusId, $timeId, $groupId, $userId) {

        // db接続
        $connectionManager = new ConnectionManager();

        // sql作成
        $sql = "SELECT * FROM acter WHERE user_id=:user_id";
        if ($acterId != null) {
            $sql .= "AND acter_id=:acter_id ";
        }
        if ($acterName != null) {
            $sql .= "AND acter_name=:acter_name ";
        }
        if ($acterInfo != null) {
            $sql .= "AND acter_info=:acter_info ";
        }
        if ($acterImg != null) {
            $sql .= "AND acter_img=:acter_img ";
        }
        if ($opusId != null) {
            $sql .= "AND opus_id=:opus_id ";
        }
        if ($timeId != null) {
            $sql .= "AND time_id=:time_id ";
        }
        if ($groupId != null) {
            $sql .= "AND group_id=:group_id ";
        }
        $sql .= ";";

        // db接続
        $connectionManager = new ConnectionManager();

        // プリペアドステートメントを作成
        $stmt = $connectionManager->getDB()->prepare($sql);

        // プレースホルダと変数をバインド
        $stmt->bindParam(':user_id', $userId);
        if ($acterId != null) {
            $stmt->bindParam(':acter_id', $acterId);
        }
        if ($acterName != null) {
            $stmt->bindParam(':acter_name', $acterName);
        }
        if ($acterInfo != null) {
            $stmt->bindParam(':acter_info', $acterInfo);
        }
        if ($acterImg != null) {
            $stmt->bindParam(':acter_img', $acterImg);
        }
        if ($opusId != null) {
            $stmt->bindParam(':opus_id', $opusId);
        }
        if ($timeId != null) {
            $stmt->bindParam(':time_id', $timeId);
        }
        if ($groupId != null) {
            $stmt->bindParam(':group_id', $groupId);
        }

        //  sql実行
        $stmt->execute();

        $dtoList = array();
        foreach ($stmt->fetchAll() as $row) {
            $dto = array(
                "acter_id" => $row['acter_id'],
                "acter_name" => $row['acter_name'],
                "acter_info" => $row['acter_info'],
                "acter_img" => $row['acter_img'],
                "opus_id" => $row['opus_id'],
                "time_id" => $row['time_id'],
                "group_id" => $row['group_id'],
                "user_id" => $row['user_id'],
                "version" => $row['version']
            );
            array_push($dtoList, $dto);
        }

        return $dtoList;
    }

    /**
     * 登場人物IDをキーに登場人物情報を取得します
     */
    public function selectById($selectId) {

        // sql作成
        $sql = "SELECT * FROM acter WHERE acter_id = ?;";

        // db接続
        $connectionManager = new ConnectionManager();

        // プリペアドステートメントを作成
        $stmt = $connectionManager->getDB()->prepare($sql);

        // プレースホルダと変数をバインド
        $stmt->bindParam(1, $selectId);

        //  sql実行
        $stmt->execute();

        // sql結果を配列に格納
        $result = $stmt->fetchAll();

        // ユーザ情報
        $dto = array();

        if (!empty($result)) {
            // 実行結果を格納
            $dto = array(
                "acter_id" => $result[0]['acter_id'],
                "acter_name" => $result[0]['acter_name'],
                "acter_info" => $result[0]['acter_info'],
                "acter_img" => $result[0]['acter_img'],
                "opus_id" => $result[0]['opus_id'],
                "time_id" => $result[0]['time_id'],
                "group_id" => $result[0]['group_id'],
                "user_id" => $result[0]['user_id'],
                "version" => $result[0]['version']
            );
        }

        return $dto;
    }

    /**
     * 登場人物情報を登録します
     */
    public function insert($acterId, $acterName, $acterInfo, $acterImg, $opusId, $timeId, $groupId, $userId, $version = 0) {

        // sql作成
        $sql = "INSERT INTO acter ( acter_id, acter_name, acter_info, acter_img, opus_id, time_id, group_id, user_id, version ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ? );";

        // db接続
        $connectionManager = new ConnectionManager();

        // プリペアドステートメントを作成
        $stmt = $connectionManager->getDB()->prepare($sql);

        // プレースホルダと変数をバインド
        $stmt->bindParam(1, $acterId);
        $stmt->bindParam(2, $acterName);
        $stmt->bindParam(3, $acterInfo);
        $stmt->bindParam(4, $acterImg);
        $stmt->bindParam(5, $opusId);
        $stmt->bindParam(6, $timeId);
        $stmt->bindParam(7, $groupId);
        $stmt->bindParam(8, $userId);
        $stmt->bindParam(9, $version);

        //  sql実行
        $stmt->execute();
    }

    /**
     * 登場人物情報を更新します
     */
    public function update($acterId, $acterName, $acterInfo, $acterImg, $opusId, $timeId, $groupId, $version = 0) {

        // sql作成
        $sql = "UPDATE acter SET ";
        if ($acterName != null) {
            $sql .= "acter_name=:acter_name, ";
        }
        if ($acterInfo != null) {
            $sql .= "acter_info=:acter_info, ";
        }
        if ($acterImg != null) {
            $sql .= "acter_img=:acter_img, ";
        }
        if ($opusId != null) {
            $sql .= "opus_id=:opus_id, ";
        }
        if ($timeId != null) {
            $sql .= "time_id=:time_id, ";
        }
        if ($groupId != null) {
            $sql .= "group_id=:group_id, ";
        }
        $sql .= "version=:version WHERE acter_id=:acter_id;";

        // db接続
        $connectionManager = new ConnectionManager();

        // プリペアドステートメントを作成
        $stmt = $connectionManager->getDB()->prepare($sql);

        // プレースホルダと変数をバインド
        if ($acterName != null) {
            $stmt->bindParam(':acter_name', $acterName);
        }
        if ($acterInfo != null) {
            $stmt->bindParam(':acter_info', $acterInfo);
        }
        if ($acterImg != null) {
            $stmt->bindParam(':acter_img', $acterImg);
        }
        if ($opusId != null) {
            $stmt->bindParam(':opus_id', $opusId);
        }
        if ($timeId != null) {
            $stmt->bindParam(':time_id', $timeId);
        }
        if ($groupId != null) {
            $stmt->bindParam(':group_id', $groupId);
        }
        $stmt->bindParam(':version', $version + 1);
        $stmt->bindParam(':acter_id', $acterId);

        //  sql実行
        $stmt->execute();
    }

    /**
     * 登場人物情報を削除します
     */
    public function delete($deleteId) {

        // sql作成
        $sql = "DELETE FROM acter WHERE acter_id = :acter_id;";

        // db接続
        $connectionManager = new ConnectionManager();

        // プリペアドステートメントを作成
        $stmt = $connectionManager->getDB()->prepare($sql);

        // プレースホルダと変数をバインド
        $stmt->bindParam(':acter_id', $deleteId);

        //  sql実行
        $stmt->execute();
    }
}
