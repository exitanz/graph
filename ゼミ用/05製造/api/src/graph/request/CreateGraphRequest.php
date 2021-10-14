<?php

/**
 * グラフ登録処理の値を保持する
 */
class CreateGraphRequest {
    private $graph;
    private $userId;
    private $errorMsg = array();

    /**
     * グラフ登録処理の値を格納します
     */

    public function __construct() {
    }

    public function getGraph() {
        return $this->graph;
    }

    public function setGraph($graph) {
        $this->graph = $graph;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function getErrorMsg() {
        return $this->errorMsg;
    }

    /**
     * バリデーションチェックをします
     */
    public function validation() {
        $validationFlg = false;

        try {
            // 入力項目チェック
            if (empty($this->graph)) {
                array_push($this->errorMsg, 'エラー ：必須項目が入力されていません');
                $validationFlg = true;
            }

            // 登場人物チェック
            if (empty($this->graph['nodes'])) {
                array_push($this->errorMsg, 'エラー ：登場人物を0件でグラフ登録はできません');
                $validationFlg = true;
            }

            // ユーザIDの文字数チェック
            if (strlen($this->userId) != Constant::USER_ID_DIGIT + strlen(Constant::USER_ID_STR)) {
                array_push($this->errorMsg, 'エラー ：ユーザIDは' . Constant::USER_ID_DIGIT + strlen(Constant::USER_ID_STR) . '文字で入力してください');
                $validationFlg = true;
            }
        } catch (Exception $e) {
            $validationFlg = true;
        }

        return $validationFlg;
    }
}
