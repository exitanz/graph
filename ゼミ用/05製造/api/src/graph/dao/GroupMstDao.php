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
     * 時系列情報を取得します
     */
    public function selectAll() {

        // db接続
        $connectionManager = new ConnectionManager();

        // sql作成
        $sql = "SELECT * FROM time_mst;";

        // データベースへの接続を表すPDOインスタンスを生成
        $pdo = $connectionManager->getDB();

        // プリペアドステートメントを作成
        $stmt = $pdo->prepare($sql);

        //  sql実行
        $stmt->execute();

        $dtoList = array();
        foreach ($stmt->fetchAll() as $row) {
            $dto = array(
                "time_id" => $row['time_id'],
                "time_name" => $row['time_name'],
                "user_id" => $row['user_id'],
                "version" => $row['version']
            );
            array_push($dtoList, $dto);
        }

        return $dtoList;
    }

    /**
     * 時系列情報を取得します
     */
    public function select($timeId, $timeName, $opusId, $userId, $offset, $limit) {

        // db接続
        $connectionManager = new ConnectionManager();

        // sql作成
        $sql = "SELECT * FROM time_mst WHERE ";
        if ($timeId != null) {
            $sql .= "time_id=:time_id AND ";
        }
        if ($timeName != null) {
            $sql .= 'time_name LIKE :time_name AND ';
        }
        if ($opusId != null) {
            $sql .= 'opus_id=:opus_id AND ';
        }
        $sql .= "user_id=:user_id LIMIT :offset, :limit;";

        // データベースへの接続を表すPDOインスタンスを生成
        $pdo = $connectionManager->getDB();

        // プリペアドステートメントを作成
        $stmt = $pdo->prepare($sql);

        // プレースホルダと変数をバインド
        if ($timeId != null) {
            $stmt->bindParam(':time_id', $timeId);
        }
        if ($timeName != null) {
            $timeNameStr = '%' . $timeName . '%';
            $stmt->bindParam(':time_name', $timeNameStr);
        }
        if ($opusId != null) {
            $stmt->bindParam(':opus_id', $opusId);
        }
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);

        //  sql実行
        $stmt->execute();

        $dtoList = array();
        foreach ($stmt->fetchAll() as $row) {
            $dto = array(
                "time_id" => $row['time_id'],
                "time_name" => $row['time_name'],
                "opus_id" => $row['opus_id'],
                "user_id" => $row['user_id'],
                "version" => $row['version']
            );
            array_push($dtoList, $dto);
        }

        return $dtoList;
    }

    /**
     * 時系列情報を取得します
     */
    public function selectById($timeId, $timeName, $userId) {

        // db接続
        $connectionManager = new ConnectionManager();

        // sql作成
        $sql = "SELECT * FROM time_mst WHERE ";
        if ($timeId != null) {
            $sql .= "time_id=:time_id AND ";
        }
        if ($timeName != null) {
            $sql .= 'time_name LIKE :time_name AND ';
        }
        $sql .= "user_id=:user_id;";

        // データベースへの接続を表すPDOインスタンスを生成
        $pdo = $connectionManager->getDB();

        // プリペアドステートメントを作成
        $stmt = $pdo->prepare($sql);

        // プレースホルダと変数をバインド
        if ($timeId != null) {
            $stmt->bindParam(':time_id', $timeId);
        }
        if ($timeName != null) {
            $timeNameStr = '%' . $timeName . '%';
            $stmt->bindParam(':time_name', $timeNameStr);
        }
        $stmt->bindParam(':user_id', $userId);

        //  sql実行
        $stmt->execute();

        $dtoList = array();
        foreach ($stmt->fetchAll() as $row) {
            $dto = array(
                "time_id" => $row['time_id'],
                "time_name" => $row['time_name'],
                "opus_id" => $row['opus_id'],
                "user_id" => $row['user_id'],
                "version" => $row['version']
            );
            array_push($dtoList, $dto);
        }

        return $dtoList;
    }

    /**
     * 時系列情報を取得します
     */
    public function selectByIdAndVersion($timeId, $timeName, $userId, $version) {

        // db接続
        $connectionManager = new ConnectionManager();

        // sql作成
        $sql = "SELECT * FROM time_mst WHERE ";
        $sql .= "time_id=:time_id AND ";
        if ($timeName != null) {
            $sql .= 'time_name LIKE :time_name AND ';
        }
        $sql .= "version=:version AND user_id=:user_id;";

        // データベースへの接続を表すPDOインスタンスを生成
        $pdo = $connectionManager->getDB();

        // プリペアドステートメントを作成
        $stmt = $pdo->prepare($sql);

        // プレースホルダと変数をバインド
        $stmt->bindParam(':time_id', $timeId);
        if ($timeName != null) {
            $timeNameStr = '%' . $timeName . '%';
            $stmt->bindParam(':time_name', $timeNameStr);
        }
        $stmt->bindParam(':version', $version);
        $stmt->bindParam(':user_id', $userId);

        //  sql実行
        $stmt->execute();

        $dtoList = array();
        foreach ($stmt->fetchAll() as $row) {
            $dto = array(
                "time_id" => $row['time_id'],
                "time_name" => $row['time_name'],
                "opus_id" => $row['opus_id'],
                "user_id" => $row['user_id'],
                "version" => $row['version']
            );
            array_push($dtoList, $dto);
        }

        return $dtoList;
    }

    /**
     * 時系列情報を登録します
     */
    public function insert($groupId, $groupName, $groupInfo, $opusId, $timeId, $userId) {

        // sql作成
        $sql = "INSERT INTO group_mst (group_id, group_name, ";
        if ($groupInfo != null) {
            $sql .= 'group_info, ';
        }
        $sql .= "opus_id, time_id, user_id) VALUES (:group_id, :group_name, ";
        if ($groupInfo != null) {
            $sql .= ':group_info, ';
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
        $stmt->bindParam(':opus_id', $opusId);
        $stmt->bindParam(':time_id', $timeId);
        $stmt->bindParam(':user_id', $userId);

        //  sql実行
        $stmt->execute();
    }

    /**
     * 時系列情報を更新します
     */
    public function update($timeId, $timeName, $userId, $version) {

        // sql作成
        $sql = "UPDATE time_mst SET ";
        if ($timeName != null) {
            $sql .= "time_name=:time_name, ";
        }
        $sql .= "version=:version WHERE time_id=:time_id AND user_id=:user_id;";

        // db接続
        $connectionManager = new ConnectionManager();

        // プリペアドステートメントを作成
        $stmt = $connectionManager->getDB()->prepare($sql);

        // プレースホルダと変数をバインド
        if ($timeName != null) {
            $stmt->bindParam(':time_name', $timeName);
        }
        $version++;
        $stmt->bindParam(':version', $version);
        $stmt->bindParam(':time_id', $timeId);
        $stmt->bindParam(':user_id', $userId);

        //  sql実行
        return $stmt->execute();
    }

    /**
     * ユーザ情報を削除します
     */
    public function delete($timeId, $userId) {

        // sql作成
        $sql = "DELETE FROM time_mst WHERE time_id = :time_id AND user_id = :user_id;";

        // db接続
        $connectionManager = new ConnectionManager();

        // プリペアドステートメントを作成
        $stmt = $connectionManager->getDB()->prepare($sql);

        // プレースホルダと変数をバインド
        $stmt->bindParam(':time_id', $timeId);
        $stmt->bindParam(':user_id', $userId);

        //  sql実行
        return $stmt->execute();
    }
}
