<?php
require_once dirname(__FILE__) . '/ConnectionManager.php';

class ActorDao {

    /**
     * 最大値の登場人物IDを取得します
     */
    public function selectMaxId() {

        // db接続
        $connectionManager = new ConnectionManager();

        // sql作成
        $sql = "SELECT Max(actor_id) AS actor_id FROM actor;";

        // データベースへの接続を表すPDOインスタンスを生成
        $pdo = $connectionManager->getDB();

        // プリペアドステートメントを作成
        $stmt = $pdo->prepare($sql);

        //  sql実行
        $stmt->execute();

        // sql結果を配列に格納
        $result = $stmt->fetchAll();

        return $result[0]['actor_id'];
    }

    /**
     * 登場人物情報を取得します
     */
    public function selectAll() {

        // db接続
        $connectionManager = new ConnectionManager();

        // sql作成
        $sql = "SELECT * FROM actor;";

        // データベースへの接続を表すPDOインスタンスを生成
        $pdo = $connectionManager->getDB();

        // プリペアドステートメントを作成
        $stmt = $pdo->prepare($sql);

        //  sql実行
        $stmt->execute();

        $dtoList = array();
        foreach ($stmt->fetchAll() as $row) {
            $dto = array(
                "actor_id" => $row['actor_id'],
                "actor_name" => $row['actor_name'],
                "actor_info" => $row['actor_info'],
                "actor_img" => $row['actor_img'],
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
     * 登場人物情報を取得します
     */
    public function select(
        $actorId,
        $actorName,
        $actorInfo,
        $opusId,
        $timeId,
        $groupId,
        $userId,
        $offset,
        $limit
    ) {

        // db接続
        $connectionManager = new ConnectionManager();

        // sql作成
        $sql = "SELECT * FROM actor WHERE ";
        if ($actorId != null) {
            $sql .= "AND actor_id=:actor_id ";
        }
        if ($actorName != null) {
            $sql .= "AND actor_name LIKE :actor_name ";
        }
        if ($actorInfo != null) {
            $sql .= "AND actor_info=:actor_info ";
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
        $sql .= "user_id=:user_id LIMIT :offset, :limit;";

        // db接続
        $connectionManager = new ConnectionManager();

        // プリペアドステートメントを作成
        $stmt = $connectionManager->getDB()->prepare($sql);

        // プレースホルダと変数をバインド
        if ($actorId != null) {
            $stmt->bindParam(':actor_id', $actorId);
        }
        if ($actorName != null) {
            $actorNameStr = '%' . $actorName . '%';
            $stmt->bindParam(':actor_name', $actorNameStr);
        }
        if ($actorInfo != null) {
            $stmt->bindParam(':actor_info', $actorInfo);
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
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);

        //  sql実行
        $stmt->execute();

        $dtoList = array();
        foreach ($stmt->fetchAll() as $row) {
            $dto = array(
                "actor_id" => $row['actor_id'],
                "actor_name" => $row['actor_name'],
                "actor_info" => $row['actor_info'],
                "actor_img" => $row['actor_img'],
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
    public function selectById($selectId, $userId) {

        // sql作成
        $sql = "SELECT * FROM actor WHERE actor_id=:actor_id AND user_id=:user_id;";

        // db接続
        $connectionManager = new ConnectionManager();

        // プリペアドステートメントを作成
        $stmt = $connectionManager->getDB()->prepare($sql);

        // プレースホルダと変数をバインド
        $stmt->bindParam(':actor_id', $selectId);
        $stmt->bindParam(':user_id', $userId);

        //  sql実行
        $stmt->execute();

        // sql結果を配列に格納
        $result = $stmt->fetchAll();

        // ユーザ情報
        $dto = array();

        if (!empty($result)) {
            // 実行結果を格納
            $dto = array(
                "actor_id" => $result[0]['actor_id'],
                "actor_name" => $result[0]['actor_name'],
                "actor_info" => $result[0]['actor_info'],
                "actor_img" => $result[0]['actor_img'],
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
     * 登場人物情報を取得します
     */
    public function selectByIdAndVersion($selectId, $userId, $version) {

        // db接続
        $connectionManager = new ConnectionManager();

        // sql作成
        $sql = "SELECT * FROM actor WHERE actor_id=:actor_id AND version=:version AND user_id=:user_id;";

        // データベースへの接続を表すPDOインスタンスを生成
        $pdo = $connectionManager->getDB();

        // プリペアドステートメントを作成
        $stmt = $pdo->prepare($sql);

        // プレースホルダと変数をバインド
        $stmt->bindParam(':actor_id', $selectId);
        $stmt->bindParam(':version', $version);
        $stmt->bindParam(':user_id', $userId);

        //  sql実行
        $stmt->execute();

        $dtoList = array();
        foreach ($stmt->fetchAll() as $row) {
            $dto = array(
                "actor_id" => $row['actor_id'],
                "actor_name" => $row['actor_name'],
                "actor_info" => $row['actor_info'],
                "actor_img" => $row['actor_img'],
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
     * 登場人物情報を登録します
     */
    public function insert($actorId, $actorName, $actorInfo, $actorImg, $opusId, $timeId, $groupId, $userId, $version = 0) {

        // sql作成
        $sql = "INSERT INTO actor(actor_id, actor_name, actor_info, actor_img, opus_id, time_id, group_id, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";

        // db接続
        $connectionManager = new ConnectionManager();

        // プリペアドステートメントを作成
        $stmt = $connectionManager->getDB()->prepare($sql);

        // プレースホルダと変数をバインド
        $stmt->bindParam(1, $actorId);
        $stmt->bindParam(2, $actorName);
        $stmt->bindParam(3, $actorInfo);
        $stmt->bindParam(4, $actorImg);
        $stmt->bindParam(5, $opusId);
        $stmt->bindParam(6, $timeId);
        $stmt->bindParam(7, $groupId);
        $stmt->bindParam(8, $userId);

        //  sql実行
        $stmt->execute();
    }

    /**
     * 登場人物情報を更新します
     */
    public function update(
        $actorId,
        $actorName,
        $actorInfo,
        $actorImg,
        $opusId,
        $timeId,
        $groupId,
        $userId, 
        $version
    ) {

        // sql作成
        $sql = "UPDATE actor SET ";
        if ($actorName != null) {
            $sql .= "actor_name=:actor_name, ";
        }
        if ($actorInfo != null) {
            $sql .= "actor_info=:actor_info, ";
        }
        if ($actorImg != null) {
            $sql .= "actor_img=:actor_img, ";
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
        $sql .= "version=:version WHERE actor_id=:actor_id AND user_id=:user_id;";

        // db接続
        $connectionManager = new ConnectionManager();

        // プリペアドステートメントを作成
        $stmt = $connectionManager->getDB()->prepare($sql);

        // プレースホルダと変数をバインド
        if ($actorName != null) {
            $stmt->bindParam(':actor_name', $actorName);
        }
        if ($actorInfo != null) {
            $stmt->bindParam(':actor_info', $actorInfo);
        }
        if ($actorImg != null) {
            $stmt->bindParam(':actor_img', $actorImg);
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
        $stmt->bindParam(':actor_id', $actorId);
        $stmt->bindParam(':user_id', $userId);

        //  sql実行
        $stmt->execute();
    }

    /**
     * 登場人物情報を削除します
     */
    public function delete($deleteId, $userId) {

        // sql作成
        $sql = "DELETE FROM actor WHERE actor_id = :actor_id AND user_id = :user_id;";

        // db接続
        $connectionManager = new ConnectionManager();

        // プリペアドステートメントを作成
        $stmt = $connectionManager->getDB()->prepare($sql);

        // プレースホルダと変数をバインド
        $stmt->bindParam(':actor_id', $deleteId);
        $stmt->bindParam(':user_id', $userId);

        //  sql実行
        $stmt->execute();
    }
}
