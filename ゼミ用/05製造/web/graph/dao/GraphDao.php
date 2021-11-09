<?php
require_once dirname(__FILE__) . '/ConnectionManager.php';

class GraphDao {

    /**
     * 登場人物グラフ情報を取得します
     */
    public function selectGraphNodes($timeId, $opusId, $actorName, $groupName) {

        // db接続
        $connectionManager = new ConnectionManager();

        // sql作成
        $sql = "SELECT CAST(REPLACE(actor.actor_id, 'actor', '') AS SIGNED) AS id, actor.actor_id, actor.actor_name AS name, actor.actor_info, actor.actor_img, actor.group_id, actor.time_id, actor.opus_id, actor.version, group_mst.group_name, time_mst.time_name, opus.opus_name, group_mst.group_color AS _color, group_mst.group_info FROM actor INNER JOIN group_mst ON actor.group_id = group_mst.group_id INNER JOIN time_mst ON actor.time_id = time_mst.time_id INNER JOIN opus ON actor.opus_id = opus.opus_id WHERE ";
        if ($actorName != null) {
            $sql .= "actor.actor_name LIKE :actor_name AND ";
        }
        if ($groupName != null) {
            $sql .= "group_mst.group_name LIKE :group_name AND ";
        }
        $sql .= "actor.time_id = :time_id AND actor.opus_id = :opus_id;";

        // データベースへの接続を表すPDOインスタンスを生成
        $pdo = $connectionManager->getDB();

        // プリペアドステートメントを作成
        $stmt = $pdo->prepare($sql);

        // プレースホルダと変数をバインド
        $stmt->bindParam(':time_id', $timeId);
        $stmt->bindParam(':opus_id', $opusId);
        if ($actorName != null) {
            $actorNameStr = '%' . $actorName . '%';
            $stmt->bindParam(':actor_name', $actorNameStr);
        }
        if ($groupName != null) {
            $groupNameStr = '%' . $groupName . '%';
            $stmt->bindParam(':group_name', $groupNameStr);
        }

        //  sql実行
        $stmt->execute();

        $dtoList = array();
        foreach ($stmt->fetchAll() as $row) {
            $dto = array(
                "id" => $row['id'],
                "name" => $row['name'],
                "_color" => $row['_color'],
                "actor_id" => $row['actor_id'],
                "actor_info" => $row['actor_info'],
                "actor_img" => $row['actor_img'],
                "group_id" => $row['group_id'],
                "group_name" => $row['group_name'],
                "group_info" => $row['group_info'],
                "time_id" => $row['time_id'],
                "time_name" => $row['time_name'],
                "opus_id" => $row['opus_id'],
                "opus_name" => $row['opus_name'],
                "version" => $row['version']
            );
            array_push($dtoList, $dto);
        }

        return $dtoList;
    }

    /**
     * 関係グラフ情報を取得します
     */
    public function selectGraphLinks($timeId, $opusId, $relMstName) {

        // db接続
        $connectionManager = new ConnectionManager();

        // sql作成
        $sql = "SELECT CAST(REPLACE(rel.actor_id, 'actor', '') AS SIGNED) AS sid, CAST(REPLACE(rel.target_id, 'actor', '') AS SIGNED) AS tid, rel.rel_id, rel.rel_mst_id, rel.rel_mst_info, rel.time_id, rel.opus_id, rel.version, rel_mst.rel_mst_name, time_mst.time_name, opus.opus_name FROM rel INNER JOIN rel_mst ON rel.rel_mst_id = rel_mst.rel_mst_id INNER JOIN time_mst ON rel.time_id = time_mst.time_id INNER JOIN opus ON rel.opus_id = opus.opus_id WHERE ";
        if ($relMstName != null) {
            $sql .= "rel_mst.rel_mst_name LIKE :rel_mst_name AND ";
        }
        $sql .= "rel.time_id = :time_id AND rel.opus_id = :opus_id;";

        // データベースへの接続を表すPDOインスタンスを生成
        $pdo = $connectionManager->getDB();

        // プリペアドステートメントを作成
        $stmt = $pdo->prepare($sql);

        // プレースホルダと変数をバインド
        $stmt->bindParam(':time_id', $timeId);
        $stmt->bindParam(':opus_id', $opusId);
        if ($relMstName != null) {
            $relMstNameStr = '%' . $relMstName . '%';
            $stmt->bindParam(':rel_mst_name', $relMstNameStr);
        }

        //  sql実行
        $stmt->execute();

        $dtoList = array();
        foreach ($stmt->fetchAll() as $row) {
            $dto = array(
                "sid" => $row['sid'],
                "tid" => $row['tid'],
                "rel_id" => $row['rel_id'],
                "rel_mst_id" => $row['rel_mst_id'],
                "rel_mst_name" => $row['rel_mst_name'],
                "rel_mst_info" => $row['rel_mst_info'],
                "time_id" => $row['time_id'],
                "time_name" => $row['time_name'],
                "opus_id" => $row['opus_id'],
                "opus_name" => $row['opus_name'],
                "version" => $row['version']
            );
            array_push($dtoList, $dto);
        }

        return $dtoList;
    }
}
