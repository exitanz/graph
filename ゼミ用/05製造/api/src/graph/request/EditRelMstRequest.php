<?php

/**
 * 関係性編集処理の値を保持する
 */
class EditRelMstRequest {
    private $relMstId;
    private $relMstName;
    private $userId;
    private $version = 0;
    private $errorMsg = array();

    /**
     * 関係性編集処理の値を格納します
     */
    public function __construct() {
    }

    public function getRelMstId() {
        return $this->relMstId;
    }

    public function setRelMstId($relMstId) {
        $this->relMstId = $relMstId;
    }

    public function getRelMstName() {
        return $this->relMstName;
    }

    public function setRelMstName($relMstName) {
        $this->relMstName = $relMstName;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function getVersion() {
        return $this->version;
    }

    public function setVersion($version) {
        $this->version = $version;
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
            if (empty($this->relMstName) || empty($this->relMstId)) {
                array_push($this->errorMsg, 'エラー ：必須項目が入力されていません');
                $validationFlg = true;
            }

            // 関係性IDの文字数チェック
            if (strlen($this->relMstId) != Constant::REL_MST_ID_DIGIT + strlen(Constant::REL_MST_ID_STR)) {
                array_push($this->errorMsg, 'エラー ：関係性IDは'.Constant::REL_MST_ID_DIGIT + strlen(Constant::REL_MST_ID_STR).'文字で入力してください');
                $validationFlg = true;
            }

            // 関係性名の文字数チェック
            if (100 < strlen($this->relMstName)) {
                array_push($this->errorMsg, 'エラー ：関係性名は100文字以内で入力してください');
                $validationFlg = true;
            }
        } catch (Exception $e) {
            $validationFlg = true;
        }

        return $validationFlg;
    }
}
