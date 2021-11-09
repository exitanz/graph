<?php
require_once dirname(__FILE__) . '/ConnectionManager.php';

class CommonMstDao {

    /**
     * 汎用マスタ情報を取得します
     */
    public function select($key) {

        // db接続
        $connectionManager = new ConnectionManager();

        // sql作成
        $sql = "SELECT * FROM common_mst WHERE common_key=:common_key;";

        // データベースへの接続を表すPDOインスタンスを生成
        $pdo = $connectionManager->getDB();

        // プリペアドステートメントを作成
        $stmt = $pdo->prepare($sql);

        // プレースホルダと変数をバインド
        $stmt->bindParam(':common_key', $key);

        //  sql実行
        $stmt->execute();

        $dtoList = array();
        foreach ($stmt->fetchAll() as $row) {
            $dto = array(
                "common_id" => $row['common_id'],
                "common_key" => $row['common_key'],
                "common_value" => $row['common_value'],
                "common_info" => $row['common_info']
            );
            array_push($dtoList, $dto);
        }

        return $dtoList;
    }
}
