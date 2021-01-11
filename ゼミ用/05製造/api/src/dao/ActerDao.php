<?php
require_once dirname(__FILE__).'/ConnectionManager.php';

class ActerDao {

    public function selectAll($sql) {

        $db = new ConnectionManager();

        try {
            // データベースへの接続を表すPDOインスタンスを生成
            $pdo = new PDO($db->getDB());

            // プリペアドステートメントを作成
            $stmt = $pdo->prepare($sql);

            // プレースホルダと変数をバインド
            $stmt->bindParam(":id", $id);

            $stmt->execute();

            // データを取得
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);

            // 接続を閉じる
            //$pdo = null; スクリプト終了時に自動で切断されるので不要
        } catch (PDOException $e) {
            // UTF8に文字エンコーディングを変換します
            exit(mb_convert_encoding($e->getMessage(), 'UTF-8', 'SJIS-win'));
        }
    }
}
