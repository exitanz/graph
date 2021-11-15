<?php
require_once dirname(__FILE__) . '/ConnectionManager.php';

class RelDao {

    /**
     * 最大値の関係IDを取得します
     */
    public function selectMaxId() {

        // db接続
        $connectionManager = new ConnectionManager();

        // sql作成
        $sql = "SELECT Max(rel_id) AS rel_id FROM rel;";

        // データベースへの接続を表すPDOインスタンスを生成
        $pdo = $connectionManager->getDB();

        // プリペアドステートメントを作成
        $stmt = $pdo->prepare($sql);

        //  sql実行
        $stmt->execute();

        // sql結果を配列に格納
        $result = $stmt->fetchAll();

        return $result[0]['rel_id'];
    }

    /**
     * 関係情報を取得します
     */
    public function selectAll() {

        // db接続
        $connectionManager = new ConnectionManager();

        // sql作成
        $sql = "SELECT * FROM rel;";

        // データベースへの接続を表すPDOインスタンスを生成
        $pdo = $connectionManager->getDB();

        // プリペアドステートメントを作成
        $stmt = $pdo->prepare($sql);

        //  sql実行
        $stmt->execute();

        $dtoList = array();
        foreach ($stmt->fetchAll() as $row) {
            $dto = array(
                "rel_id" => $row['rel_id'],
                "rel_mst_id" => $row['rel_mst_id'],
                "rel_mst_info" => $row['rel_mst_info'],
                "actor_id" => $row['actor_id'],
                "target_id" => $row['target_id'],
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
     * 関係情報を取得します
     */
    public function select(
        $relId,
        $relMstId,
        $relMstInfo,
        $actorId,
        $targetId,
        $opusId,
        $timeId,
        $userId,
        $offset,
        $limit
    ) {

        // db接続
        $connectionManager = new ConnectionManager();

        // sql作成
        $sql = "SELECT * FROM rel WHERE ";
        if ($relId != null) {
            $sql .= "rel_id=:rel_id AND ";
        }
        if ($relMstId != null) {
            $sql .= "rel_mst_id=:rel_mst_id AND ";
        }
        if ($relMstInfo != null) {
            $sql .= 'rel_mst_info LIKE :rel_mst_info AND ';
        }
        if ($actorId != null) {
            $sql .= 'actor_id=:actor_id AND ';
        }
        if ($targetId != null) {
            $sql .= 'target_id=:target_id AND ';
        }
        if ($opusId != null) {
            $sql .= 'opus_id=:opus_id AND ';
        }
        if ($timeId != null) {
            $sql .= 'time_id=:time_id AND ';
        }
        $sql .= "user_id=:user_id LIMIT :limit OFFSET :offset;";

        // データベースへの接続を表すPDOインスタンスを生成
        $pdo = $connectionManager->getDB();

        // プリペアドステートメントを作成
        $stmt = $pdo->prepare($sql);

        // プレースホルダと変数をバインド
        if ($relId != null) {
            $stmt->bindParam(':rel_id', $relId);
        }
        if ($relMstId != null) {
            $stmt->bindParam(':rel_mst_id', $relMstId);
        }
        if ($relMstInfo != null) {
            $relMstInfoStr = '%' . $relMstInfo . '%';
            $stmt->bindParam(':rel_mst_info', $relMstInfoStr);
        }
        if ($actorId != null) {
            $stmt->bindParam(':actor_id', $actorId);
        }
        if ($targetId != null) {
            $stmt->bindParam(':target_id', $targetId);
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
                "rel_id" => $row['rel_id'],
                "rel_mst_id" => $row['rel_mst_id'],
                "rel_mst_info" => $row['rel_mst_info'],
                "actor_id" => $row['actor_id'],
                "target_id" => $row['target_id'],
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
     * 関係情報を取得します
     */
    public function selectById($relId, $userId) {

        // db接続
        $connectionManager = new ConnectionManager();

        // sql作成
        $sql = "SELECT * FROM rel WHERE ";
        if ($relId != null) {
            $sql .= "rel_id=:rel_id AND ";
        }
        $sql .= "user_id=:user_id;";

        // データベースへの接続を表すPDOインスタンスを生成
        $pdo = $connectionManager->getDB();

        // プリペアドステートメントを作成
        $stmt = $pdo->prepare($sql);

        // プレースホルダと変数をバインド
        if ($relId != null) {
            $stmt->bindParam(':rel_id', $relId);
        }
        $stmt->bindParam(':user_id', $userId);

        //  sql実行
        $stmt->execute();

        $dtoList = array();
        foreach ($stmt->fetchAll() as $row) {
            $dto = array(
                "rel_id" => $row['rel_id'],
                "rel_mst_id" => $row['rel_mst_id'],
                "rel_mst_info" => $row['rel_mst_info'],
                "actor_id" => $row['actor_id'],
                "target_id" => $row['target_id'],
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
     * 関係情報を取得します
     */
    public function selectByIdAndVersion($relId, $userId, $version) {

        // db接続
        $connectionManager = new ConnectionManager();

        // sql作成
        $sql = "SELECT * FROM rel WHERE rel_id=:rel_id AND version=:version AND user_id=:user_id;";

        // データベースへの接続を表すPDOインスタンスを生成
        $pdo = $connectionManager->getDB();

        // プリペアドステートメントを作成
        $stmt = $pdo->prepare($sql);

        // プレースホルダと変数をバインド
        $stmt->bindParam(':rel_id', $relId);
        $stmt->bindParam(':version', $version);
        $stmt->bindParam(':user_id', $userId);

        //  sql実行
        $stmt->execute();

        $dtoList = array();
        foreach ($stmt->fetchAll() as $row) {
            $dto = array(
                "rel_id" => $row['rel_id'],
                "rel_mst_id" => $row['rel_mst_id'],
                "rel_mst_info" => $row['rel_mst_info'],
                "actor_id" => $row['actor_id'],
                "target_id" => $row['target_id'],
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
     * 関係情報を登録します
     */
    public function insert(
        $relId,
        $relMstId,
        $relMstInfo,
        $actorId,
        $targetId,
        $opusId,
        $timeId,
        $userId
    ) {

        // sql作成
        $sql = "INSERT INTO rel(rel_id, rel_mst_id, ";
        if ($relMstInfo != null) {
            $sql .= "rel_mst_info, ";
        }
        $sql .= "actor_id, target_id, opus_id, time_id, user_id) VALUES (:rel_id, :rel_mst_id, ";
        if ($relMstInfo != null) {
            $sql .= ":rel_mst_info, ";
        }
        $sql .= ":actor_id, :target_id, :opus_id, :time_id, :user_id);";

        // db接続
        $connectionManager = new ConnectionManager();

        // プリペアドステートメントを作成
        $stmt = $connectionManager->getDB()->prepare($sql);

        // プレースホルダと変数をバインド
        $stmt->bindParam(':rel_id', $relId);
        $stmt->bindParam(':rel_mst_id', $relMstId);
        if ($relMstInfo != null) {
            $stmt->bindParam(':rel_mst_info', $relMstInfo);
        }
        $stmt->bindParam(':actor_id', $actorId);
        $stmt->bindParam(':target_id', $targetId);
        $stmt->bindParam(':opus_id', $opusId);
        $stmt->bindParam(':time_id', $timeId);
        $stmt->bindParam(':user_id', $userId);

        //  sql実行
        $stmt->execute();
    }

    /**
     * 関係情報を更新します
     */
    public function update(
        $relId,
        $relMstId,
        $relMstInfo,
        $actorId,
        $targetId,
        $opusId,
        $timeId,
        $userId,
        $version
    ) {

        // sql作成
        $sql = "UPDATE rel SET ";
        if ($relMstId != null) {
            $sql .= "rel_mst_id=:rel_mst_id, ";
        }
        if ($relMstInfo != null) {
            $sql .= "rel_mst_info=:rel_mst_info, ";
        }
        if ($actorId != null) {
            $sql .= "actor_id=:actor_id, ";
        }
        if ($targetId != null) {
            $sql .= "target_id=:target_id, ";
        }
        if ($opusId != null) {
            $sql .= "opus_id=:opus_id, ";
        }
        if ($timeId != null) {
            $sql .= "time_id=:time_id, ";
        }
        $sql .= "version=:version WHERE rel_id=:rel_id AND user_id=:user_id;";

        // db接続
        $connectionManager = new ConnectionManager();

        // プリペアドステートメントを作成
        $stmt = $connectionManager->getDB()->prepare($sql);

        // プレースホルダと変数をバインド
        if ($relMstId != null) {
            $stmt->bindParam(':rel_mst_id', $relMstId);
        }
        if ($relMstInfo != null) {
            $stmt->bindParam(':rel_mst_info', $relMstInfo);
        }
        if ($actorId != null) {
            $stmt->bindParam(':actor_id', $actorId);
        }
        if ($targetId != null) {
            $stmt->bindParam(':target_id', $targetId);
        }
        if ($opusId != null) {
            $stmt->bindParam(':opus_id', $opusId);
        }
        if ($timeId != null) {
            $stmt->bindParam(':time_id', $timeId);
        }
        $version++;
        $stmt->bindParam(':version', $version);
        $stmt->bindParam(':rel_id', $relId);
        $stmt->bindParam(':user_id', $userId);

        //  sql実行
        return $stmt->execute();
    }

    /**
     * 関係情報を削除します
     */
    public function delete($relId, $userId) {

        // sql作成
        $sql = "DELETE FROM rel WHERE rel_id = :rel_id AND user_id = :user_id;";

        // db接続
        $connectionManager = new ConnectionManager();

        // プリペアドステートメントを作成
        $stmt = $connectionManager->getDB()->prepare($sql);

        // プレースホルダと変数をバインド
        $stmt->bindParam(':rel_id', $relId);
        $stmt->bindParam(':user_id', $userId);

        //  sql実行
        return $stmt->execute();
    }
}
