<?php
require_once dirname(__FILE__) . '/ConnectionManager.php';

class GroupMstDao {

    /**
     * 最大値の作品IDを取得します
     */
    public function selectMaxId() {

        // db接続
        $connectionManager = new ConnectionManager();

        // sql作成
        $sql = "SELECT Max(group_id) AS group_id FROM group_mst;";

        // データベースへの接続を表すPDOインスタンスを生成
        $pdo = $connectionManager->getDB();

        // プリペアドステートメントを作成
        $stmt = $pdo->prepare($sql);

        //  sql実行
        $stmt->execute();

        // sql結果を配列に格納
        $result = $stmt->fetchAll();

        return $result[0]['group_id'];
    }

    /**
     * グループ情報を取得します
     */
    public function selectAll() {

        // db接続
        $connectionManager = new ConnectionManager();

        // sql作成
        $sql = "SELECT * FROM group_mst;";

        // データベースへの接続を表すPDOインスタンスを生成
        $pdo = $connectionManager->getDB();

        // プリペアドステートメントを作成
        $stmt = $pdo->prepare($sql);

        //  sql実行
        $stmt->execute();

        $dtoList = array();
        foreach ($stmt->fetchAll() as $row) {
            $dto = array(
                "group_id" => $row['group_id'],
                "group_name" => $row['group_name'],
                "group_info" => $row['group_info'],
                "group_color" => $row['group_color'],
                "opus_id" => $row['opus_id'],
                "time_id" => $row['time_id'],
                "user_id" => $row['user_id'],
                "version" => $row['version']
            );
            array_push($dtoList, $dto);
        }

        return $dtoList;
    }

    /**
     * グループ情報を取得します
     */
    public function select($groupId, $groupName, $groupInfo, $opusId, $timeId, $userId, $offset, $limit) {

        // db接続
        $connectionManager = new ConnectionManager();

        // sql作成
        $sql = "SELECT * FROM group_mst WHERE ";
        if ($groupId != null) {
            $sql .= "group_id=:group_id AND ";
        }
        if ($groupName != null) {
            $sql .= 'group_name LIKE :group_name AND ';
        }
        if ($groupInfo != null) {
            $sql .= 'group_info LIKE :group_info AND ';
        }
        if ($opusId != null) {
            $sql .= 'opus_id=:opus_id AND ';
        }
        if ($timeId != null) {
            $sql .= 'time_id=:time_id AND ';
        }
        $sql .= "user_id=:user_id LIMIT :offset, :limit;";

        // データベースへの接続を表すPDOインスタンスを生成
        $pdo = $connectionManager->getDB();

        // プリペアドステートメントを作成
        $stmt = $pdo->prepare($sql);

        // プレースホルダと変数をバインド
        if ($groupId != null) {
            $stmt->bindParam(':group_id', $groupId);
        }
        if ($groupName != null) {
            $stmt->bindParam(':group_name', $groupName);
        }
        if ($groupInfo != null) {
            $stmt->bindParam(':group_info', $groupInfo);
        }
        if ($opusId != null) {
            $stmt->bindParam(':opus_id', $opusId);
        }
        if ($timeId != null) {
            $stmt->bindParam(':time_id', $timeId);
        }
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);

        //  sql実行
        $stmt->execute();

        $dtoList = array();
        foreach ($stmt->fetchAll() as $row) {
            $dto = array(
                "group_id" => $row['group_id'],
                "group_name" => $row['group_name'],
                "group_info" => $row['group_info'],
                "group_color" => $row['group_color'],
                "opus_id" => $row['opus_id'],
                "time_id" => $row['time_id'],
                "user_id" => $row['user_id'],
                "version" => $row['version']
            );
            array_push($dtoList, $dto);
        }

        return $dtoList;
    }

    /**
     * グループ情報を取得します
     */
    public function selectById($groupId, $userId) {

        // db接続
        $connectionManager = new ConnectionManager();

        // sql作成
        $sql = "SELECT * FROM group_mst WHERE group_id=:group_id AND user_id=:user_id;";

        // データベースへの接続を表すPDOインスタンスを生成
        $pdo = $connectionManager->getDB();

        // プリペアドステートメントを作成
        $stmt = $pdo->prepare($sql);

        // プレースホルダと変数をバインド
        $stmt->bindParam(':group_id', $groupId);
        $stmt->bindParam(':user_id', $userId);

        //  sql実行
        $stmt->execute();

        $dtoList = array();
        foreach ($stmt->fetchAll() as $row) {
            $dto = array(
                "group_id" => $row['group_id'],
                "group_name" => $row['group_name'],
                "group_info" => $row['group_info'],
                "group_color" => $row['group_color'],
                "opus_id" => $row['opus_id'],
                "time_id" => $row['time_id'],
                "user_id" => $row['user_id'],
                "version" => $row['version']
            );
            array_push($dtoList, $dto);
        }

        return $dtoList;
    }

    /**
     * グループ情報を取得します
     */
    public function selectByIdAndVersion($groupId, $userId, $version) {

        // db接続
        $connectionManager = new ConnectionManager();

        // sql作成
        $sql = "SELECT * FROM group_mst WHERE group_id=:group_id AND version=:version AND user_id=:user_id;";

        // データベースへの接続を表すPDOインスタンスを生成
        $pdo = $connectionManager->getDB();

        // プリペアドステートメントを作成
        $stmt = $pdo->prepare($sql);

        // プレースホルダと変数をバインド
        $stmt->bindParam(':group_id', $groupId);
        $stmt->bindParam(':version', $version);
        $stmt->bindParam(':user_id', $userId);

        //  sql実行
        $stmt->execute();

        $dtoList = array();
        foreach ($stmt->fetchAll() as $row) {
            $dto = array(
                "group_id" => $row['group_id'],
                "group_name" => $row['group_name'],
                "group_info" => $row['group_info'],
                "group_color" => $row['group_color'],
                "opus_id" => $row['opus_id'],
                "time_id" => $row['time_id'],
                "user_id" => $row['user_id'],
                "version" => $row['version']
            );
            array_push($dtoList, $dto);
        }

        return $dtoList;
    }

    /**
     * グループ情報を登録します
     */
    public function insert($groupId, $groupName, $groupInfo, $groupColor, $opusId, $timeId, $userId) {

        // sql作成
        $sql = "INSERT INTO group_mst (group_id, group_name, ";
        if ($groupInfo != null) {
            $sql .= 'group_info, ';
        }
        if ($groupColor != null) {
            $sql .= 'group_color, ';
        }
        $sql .= "opus_id, time_id, user_id) VALUES (:group_id, :group_name, ";
        if ($groupInfo != null) {
            $sql .= ':group_info, ';
        }
        if ($groupColor != null) {
            $sql .= ':group_color, ';
        }
        $sql .= ":opus_id, :time_id, :user_id);";

        // db接続
        $connectionManager = new ConnectionManager();

        // プリペアドステートメントを作成
        $stmt = $connectionManager->getDB()->prepare($sql);

        // プレースホルダと変数をバインド
        $stmt->bindParam(':group_id', $groupId);
        $stmt->bindParam(':group_name', $groupName);
        if ($groupInfo != null) {
            $stmt->bindParam(':group_info', $groupInfo);
        }
        if ($groupColor != null) {
            $stmt->bindParam(':group_color', $groupColor);
        }
        $stmt->bindParam(':opus_id', $opusId);
        $stmt->bindParam(':time_id', $timeId);
        $stmt->bindParam(':user_id', $userId);

        //  sql実行
        $stmt->execute();
    }

    /**
     * グループ情報を更新します
     */
    public function update($groupId, $groupName, $groupInfo, $groupColor, $userId, $version) {

        // sql作成
        $sql = "UPDATE group_mst SET ";
        if ($groupName != null) {
            $sql .= "group_name=:group_name, ";
        }
        if ($groupInfo != null) {
            $sql .= "group_info=:group_info, ";
        }
        if ($groupColor != null) {
            $sql .= "group_color=:group_color, ";
        }
        $sql .= "version=:version WHERE group_id=:group_id AND user_id=:user_id;";

        // db接続
        $connectionManager = new ConnectionManager();

        // プリペアドステートメントを作成
        $stmt = $connectionManager->getDB()->prepare($sql);

        // プレースホルダと変数をバインド
        if ($groupName != null) {
            $stmt->bindParam(':group_name', $groupName);
        }
        if ($groupInfo != null) {
            $stmt->bindParam(':group_info', $groupInfo);
        }
        if ($groupColor != null) {
            $stmt->bindParam(':group_color', $groupColor);
        }
        $version++;
        $stmt->bindParam(':version', $version);
        $stmt->bindParam(':group_id', $groupId);
        $stmt->bindParam(':user_id', $userId);

        //  sql実行
        return $stmt->execute();
    }

    /**
     * グループ情報を削除します
     */
    public function delete($groupId, $userId) {

        // sql作成
        $sql = "DELETE FROM group_mst WHERE group_id = :group_id AND user_id = :user_id;";

        // db接続
        $connectionManager = new ConnectionManager();

        // プリペアドステートメントを作成
        $stmt = $connectionManager->getDB()->prepare($sql);

        // プレースホルダと変数をバインド
        $stmt->bindParam(':group_id', $groupId);
        $stmt->bindParam(':user_id', $userId);

        //  sql実行
        return $stmt->execute();
    }
}
