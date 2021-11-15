<?php
require_once dirname(__FILE__) . '/ConnectionManager.php';

class OpusDao {

    /**
     * 最大値の作品IDを取得します
     */
    public function selectMaxId() {

        // db接続
        $connectionManager = new ConnectionManager();

        // sql作成
        $sql = "SELECT Max(opus_id) AS opus_id FROM opus;";

        // データベースへの接続を表すPDOインスタンスを生成
        $pdo = $connectionManager->getDB();

        // プリペアドステートメントを作成
        $stmt = $pdo->prepare($sql);

        //  sql実行
        $stmt->execute();

        // sql結果を配列に格納
        $result = $stmt->fetchAll();

        return $result[0]['opus_id'];
    }

    /**
     * 作品情報を取得します
     */
    public function selectAll($userName, $opusName, $offset, $limit) {

        // db接続
        $connectionManager = new ConnectionManager();

        // sql作成
        $sql = "SELECT opus.opus_id, opus.opus_name, opus.opus_flg, opus.user_id, opus.version, cor_user.user_name FROM opus INNER JOIN cor_user ON opus.user_id = cor_user.user_id WHERE opus_flg = 1 ";
        if ($userName != null) {
            $sql .= "AND user_name LIKE :user_name ";
        }
        if ($opusName != null) {
            $sql .= "AND opus_name LIKE :opus_name ";
        }
        $sql .= "LIMIT :limit OFFSET :offset;";

        // データベースへの接続を表すPDOインスタンスを生成
        $pdo = $connectionManager->getDB();

        // プリペアドステートメントを作成
        $stmt = $pdo->prepare($sql);

        // プレースホルダと変数をバインド
        if ($userName != null) {
            $userNameStr = '%' . $userName . '%';
            $stmt->bindParam(':user_name', $userNameStr);
        }
        if ($opusName != null) {
            $opusNameStr = '%' . $opusName . '%';
            $stmt->bindParam(':opus_name', $opusNameStr);
        }
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);

        //  sql実行
        $stmt->execute();

        $dtoList = array();
        foreach ($stmt->fetchAll() as $row) {
            $dto = array(
                "opus_id" => $row['opus_id'],
                "opus_name" => $row['opus_name'],
                "user_id" => $row['user_id'],
                "user_name" => $row['user_name'],
                "version" => $row['version']
            );
            array_push($dtoList, $dto);
        }

        return $dtoList;
    }

    /**
     * 作品情報を取得します
     */
    public function select($opusId, $opusName, $userId, $offset, $limit) {

        // db接続
        $connectionManager = new ConnectionManager();

        // sql作成
        $sql = "SELECT * FROM opus WHERE ";
        if ($opusId != null) {
            $sql .= "opus_id=:opus_id AND ";
        }
        if ($opusName != null) {
            $sql .= 'opus_name LIKE :opus_name AND ';
        }
        $sql .= "user_id=:user_id LIMIT :limit OFFSET :offset;";

        // データベースへの接続を表すPDOインスタンスを生成
        $pdo = $connectionManager->getDB();

        // プリペアドステートメントを作成
        $stmt = $pdo->prepare($sql);

        // プレースホルダと変数をバインド
        if ($opusId != null) {
            $stmt->bindParam(':opus_id', $opusId);
        }
        if ($opusName != null) {
            $opusNameStr = '%' . $opusName . '%';
            $stmt->bindParam(':opus_name', $opusNameStr);
        }
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);

        //  sql実行
        $stmt->execute();

        $dtoList = array();
        foreach ($stmt->fetchAll() as $row) {
            $dto = array(
                "opus_id" => $row['opus_id'],
                "opus_name" => $row['opus_name'],
                "opus_flg" => $row['opus_flg'],
                "user_id" => $row['user_id'],
                "version" => $row['version']
            );
            array_push($dtoList, $dto);
        }

        return $dtoList;
    }

    /**
     * 作品情報を取得します
     */
    public function selectById($opusId, $opusName, $userId) {

        // db接続
        $connectionManager = new ConnectionManager();

        // sql作成
        $sql = "SELECT * FROM opus WHERE ";
        if ($opusId != null) {
            $sql .= "opus_id=:opus_id AND ";
        }
        if ($opusName != null) {
            $sql .= 'opus_name LIKE :opus_name AND ';
        }
        $sql .= "user_id=:user_id;";

        // データベースへの接続を表すPDOインスタンスを生成
        $pdo = $connectionManager->getDB();

        // プリペアドステートメントを作成
        $stmt = $pdo->prepare($sql);

        // プレースホルダと変数をバインド
        if ($opusId != null) {
            $stmt->bindParam(':opus_id', $opusId);
        }
        if ($opusName != null) {
            $opusNameStr = '%' . $opusName . '%';
            $stmt->bindParam(':opus_name', $opusNameStr);
        }
        $stmt->bindParam(':user_id', $userId);

        //  sql実行
        $stmt->execute();

        $dtoList = array();
        foreach ($stmt->fetchAll() as $row) {
            $dto = array(
                "opus_id" => $row['opus_id'],
                "opus_name" => $row['opus_name'],
                "user_id" => $row['user_id'],
                "version" => $row['version']
            );
            array_push($dtoList, $dto);
        }

        return $dtoList;
    }

    /**
     * 作品情報を取得します
     */
    public function selectByOpusId($opusId) {

        // db接続
        $connectionManager = new ConnectionManager();

        // sql作成
        $sql = "SELECT * FROM opus WHERE opus_id=:opus_id;";

        // データベースへの接続を表すPDOインスタンスを生成
        $pdo = $connectionManager->getDB();

        // プリペアドステートメントを作成
        $stmt = $pdo->prepare($sql);

        // プレースホルダと変数をバインド
        $stmt->bindParam(':opus_id', $opusId);

        //  sql実行
        $stmt->execute();

        $dtoList = array();
        foreach ($stmt->fetchAll() as $row) {
            $dto = array(
                "opus_id" => $row['opus_id'],
                "opus_name" => $row['opus_name'],
                "user_id" => $row['user_id'],
                "version" => $row['version']
            );
            array_push($dtoList, $dto);
        }

        return $dtoList;
    }

    /**
     * 作品情報を取得します
     */
    public function selectByIdAndVersion($opusId, $opusName, $userId, $version) {

        // db接続
        $connectionManager = new ConnectionManager();

        // sql作成
        $sql = "SELECT * FROM opus WHERE ";
        $sql .= "opus_id=:opus_id AND ";
        if ($opusName != null) {
            $sql .= 'opus_name LIKE :opus_name AND ';
        }
        $sql .= "version=:version AND user_id=:user_id;";

        // データベースへの接続を表すPDOインスタンスを生成
        $pdo = $connectionManager->getDB();

        // プリペアドステートメントを作成
        $stmt = $pdo->prepare($sql);

        // プレースホルダと変数をバインド
        $stmt->bindParam(':opus_id', $opusId);
        if ($opusName != null) {
            $opusNameStr = '%' . $opusName . '%';
            $stmt->bindParam(':opus_name', $opusNameStr);
        }
        $stmt->bindParam(':version', $version);
        $stmt->bindParam(':user_id', $userId);

        //  sql実行
        $stmt->execute();

        $dtoList = array();
        foreach ($stmt->fetchAll() as $row) {
            $dto = array(
                "opus_id" => $row['opus_id'],
                "opus_name" => $row['opus_name'],
                "user_id" => $row['user_id'],
                "version" => $row['version']
            );
            array_push($dtoList, $dto);
        }

        return $dtoList;
    }

    /**
     * 作品情報を登録します
     */
    public function insert($opusId, $opusName, $user_id) {

        // sql作成
        $sql = "INSERT INTO opus (opus_id, opus_name, user_id) VALUES (?, ?, ?);";

        // db接続
        $connectionManager = new ConnectionManager();

        // プリペアドステートメントを作成
        $stmt = $connectionManager->getDB()->prepare($sql);

        // プレースホルダと変数をバインド
        $stmt->bindParam(1, $opusId);
        $stmt->bindParam(2, $opusName);
        $stmt->bindParam(3, $user_id);

        //  sql実行
        $stmt->execute();
    }

    /**
     * 作品情報を更新します
     */
    public function update($opusId, $opusName, $opusFlg, $userId, $version) {

        // sql作成
        $sql = "UPDATE opus SET ";
        if ($opusName != null) {
            $sql .= "opus_name=:opus_name, ";
        }
        if ($opusFlg != null) {
            $sql .= "opus_flg=:opus_flg, ";
        }
        $sql .= "version=:version WHERE opus_id=:opus_id AND user_id=:user_id;";

        // db接続
        $connectionManager = new ConnectionManager();

        // プリペアドステートメントを作成
        $stmt = $connectionManager->getDB()->prepare($sql);

        // プレースホルダと変数をバインド
        if ($opusName != null) {
            $stmt->bindParam(':opus_name', $opusName);
        }
        if ($opusFlg != null) {
            $stmt->bindParam(':opus_flg', $opusFlg);
        }
        $version++;
        $stmt->bindParam(':version', $version);
        $stmt->bindParam(':opus_id', $opusId);
        $stmt->bindParam(':user_id', $userId);

        //  sql実行
        return $stmt->execute();
    }

    /**
     * 作品情報を削除します
     */
    public function delete($opusId, $userId) {

        // sql作成
        $sql = "DELETE FROM opus WHERE opus_id = :opus_id AND user_id = :user_id;";

        // db接続
        $connectionManager = new ConnectionManager();

        // プリペアドステートメントを作成
        $stmt = $connectionManager->getDB()->prepare($sql);

        // プレースホルダと変数をバインド
        $stmt->bindParam(':opus_id', $opusId);
        $stmt->bindParam(':user_id', $userId);

        //  sql実行
        return $stmt->execute();
    }
}
