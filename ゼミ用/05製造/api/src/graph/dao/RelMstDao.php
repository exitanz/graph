<?php
require_once dirname(__FILE__) . '/ConnectionManager.php';

class RelMstDao {

    /**
     * 最大値の関係性IDを取得します
     */
    public function selectMaxId() {

        // db接続
        $connectionManager = new ConnectionManager();

        // sql作成
        $sql = "SELECT Max(rel_mst_id) AS rel_mst_id FROM rel_mst;";

        // データベースへの接続を表すPDOインスタンスを生成
        $pdo = $connectionManager->getDB();

        // プリペアドステートメントを作成
        $stmt = $pdo->prepare($sql);

        //  sql実行
        $stmt->execute();

        // sql結果を配列に格納
        $result = $stmt->fetchAll();

        return $result[0]['rel_mst_id'];
    }

    /**
     * 関係性情報を取得します
     */
    public function selectAll() {

        // db接続
        $connectionManager = new ConnectionManager();

        // sql作成
        $sql = "SELECT * FROM rel_mst;";

        // データベースへの接続を表すPDOインスタンスを生成
        $pdo = $connectionManager->getDB();

        // プリペアドステートメントを作成
        $stmt = $pdo->prepare($sql);

        //  sql実行
        $stmt->execute();

        $dtoList = array();
        foreach ($stmt->fetchAll() as $row) {
            $dto = array(
                "rel_mst_id" => $row['rel_mst_id'],
                "rel_mst_name" => $row['rel_mst_name'],
                "opus_id" => $row['opus_id'],
                "user_id" => $row['user_id'],
                "version" => $row['version']
            );
            array_push($dtoList, $dto);
        }

        return $dtoList;
    }

    /**
     * 関係性情報を取得します
     */
    public function select($relMstId, $relMstName, $opusId, $userId, $offset, $limit) {

        // db接続
        $connectionManager = new ConnectionManager();

        // sql作成
        $sql = "SELECT * FROM rel_mst WHERE ";
        if ($relMstId != null) {
            $sql .= "rel_mst_id=:rel_mst_id AND ";
        }
        if ($relMstName != null) {
            $sql .= 'rel_mst_name LIKE :rel_mst_name AND ';
        }
        if ($opusId != null) {
            $sql .= 'opus_id=:opus_id AND ';
        }
        $sql .= "user_id=:user_id LIMIT :limit OFFSET :offset;";

        // データベースへの接続を表すPDOインスタンスを生成
        $pdo = $connectionManager->getDB();

        // プリペアドステートメントを作成
        $stmt = $pdo->prepare($sql);

        // プレースホルダと変数をバインド
        if ($relMstId != null) {
            $stmt->bindParam(':rel_mst_id', $relMstId);
        }
        if ($relMstName != null) {
            $relMstNameStr = '%' . $relMstName . '%';
            $stmt->bindParam(':rel_mst_name', $relMstNameStr);
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
                "rel_mst_id" => $row['rel_mst_id'],
                "rel_mst_name" => $row['rel_mst_name'],
                "opus_id" => $row['opus_id'],
                "user_id" => $row['user_id'],
                "version" => $row['version']
            );
            array_push($dtoList, $dto);
        }

        return $dtoList;
    }

    /**
     * 関係性情報を取得します
     */
    public function selectById($relMstId, $relMstName, $userId) {

        // db接続
        $connectionManager = new ConnectionManager();

        // sql作成
        $sql = "SELECT * FROM rel_mst WHERE ";
        if ($relMstId != null) {
            $sql .= "rel_mst_id=:rel_mst_id AND ";
        }
        if ($relMstName != null) {
            $sql .= 'rel_mst_name LIKE :rel_mst_name AND ';
        }
        $sql .= "user_id=:user_id;";

        // データベースへの接続を表すPDOインスタンスを生成
        $pdo = $connectionManager->getDB();

        // プリペアドステートメントを作成
        $stmt = $pdo->prepare($sql);

        // プレースホルダと変数をバインド
        if ($relMstId != null) {
            $stmt->bindParam(':rel_mst_id', $relMstId);
        }
        if ($relMstName != null) {
            $relMstNameStr = '%' . $relMstName . '%';
            $stmt->bindParam(':rel_mst_name', $relMstNameStr);
        }
        $stmt->bindParam(':user_id', $userId);

        //  sql実行
        $stmt->execute();

        $dtoList = array();
        foreach ($stmt->fetchAll() as $row) {
            $dto = array(
                "rel_mst_id" => $row['rel_mst_id'],
                "rel_mst_name" => $row['rel_mst_name'],
                "opus_id" => $row['opus_id'],
                "user_id" => $row['user_id'],
                "version" => $row['version']
            );
            array_push($dtoList, $dto);
        }

        return $dtoList;
    }

    /**
     * 関係性情報を取得します
     */
    public function selectByIdAndVersion($relMstId, $relMstName, $userId, $version) {

        // db接続
        $connectionManager = new ConnectionManager();

        // sql作成
        $sql = "SELECT * FROM rel_mst WHERE rel_mst_id=:rel_mst_id AND ";
        if ($relMstName != null) {
            $sql .= 'rel_mst_name LIKE :rel_mst_name AND ';
        }
        $sql .= "version=:version AND user_id=:user_id;";

        // データベースへの接続を表すPDOインスタンスを生成
        $pdo = $connectionManager->getDB();

        // プリペアドステートメントを作成
        $stmt = $pdo->prepare($sql);

        // プレースホルダと変数をバインド
        $stmt->bindParam(':rel_mst_id', $relMstId);
        if ($relMstName != null) {
            $relMstNameStr = '%' . $relMstName . '%';
            $stmt->bindParam(':rel_mst_name', $relMstNameStr);
        }
        $stmt->bindParam(':version', $version);
        $stmt->bindParam(':user_id', $userId);

        //  sql実行
        $stmt->execute();

        $dtoList = array();
        foreach ($stmt->fetchAll() as $row) {
            $dto = array(
                "rel_mst_id" => $row['rel_mst_id'],
                "rel_mst_name" => $row['rel_mst_name'],
                "opus_id" => $row['opus_id'],
                "user_id" => $row['user_id'],
                "version" => $row['version']
            );
            array_push($dtoList, $dto);
        }

        return $dtoList;
    }

    /**
     * 関係性情報を登録します
     */
    public function insert($relMstId, $relMstName, $opusId, $userId) {

        // sql作成
        $sql = "INSERT INTO rel_mst (rel_mst_id, rel_mst_name, opus_id, user_id) VALUES (?, ?, ?, ?);";

        // db接続
        $connectionManager = new ConnectionManager();

        // プリペアドステートメントを作成
        $stmt = $connectionManager->getDB()->prepare($sql);

        // プレースホルダと変数をバインド
        $stmt->bindParam(1, $relMstId);
        $stmt->bindParam(2, $relMstName);
        $stmt->bindParam(3, $opusId);
        $stmt->bindParam(4, $userId);

        //  sql実行
        $stmt->execute();
    }

    /**
     * 関係性情報を更新します
     */
    public function update($relMstId, $relMstName, $userId, $version) {

        // sql作成
        $sql = "UPDATE rel_mst SET ";
        if ($relMstName != null) {
            $sql .= "rel_mst_name=:rel_mst_name, ";
        }
        $sql .= "version=:version WHERE rel_mst_id=:rel_mst_id AND user_id=:user_id;";

        // db接続
        $connectionManager = new ConnectionManager();

        // プリペアドステートメントを作成
        $stmt = $connectionManager->getDB()->prepare($sql);

        // プレースホルダと変数をバインド
        if ($relMstName != null) {
            $stmt->bindParam(':rel_mst_name', $relMstName);
        }
        $version++;
        $stmt->bindParam(':version', $version);
        $stmt->bindParam(':rel_mst_id', $relMstId);
        $stmt->bindParam(':user_id', $userId);

        //  sql実行
        return $stmt->execute();
    }

    /**
     * 関係性情報を削除します
     */
    public function delete($relMstId, $userId) {

        // sql作成
        $sql = "DELETE FROM rel_mst WHERE rel_mst_id = :rel_mst_id AND user_id = :user_id;";

        // db接続
        $connectionManager = new ConnectionManager();

        // プリペアドステートメントを作成
        $stmt = $connectionManager->getDB()->prepare($sql);

        // プレースホルダと変数をバインド
        $stmt->bindParam(':rel_mst_id', $relMstId);
        $stmt->bindParam(':user_id', $userId);

        //  sql実行
        return $stmt->execute();
    }
}
