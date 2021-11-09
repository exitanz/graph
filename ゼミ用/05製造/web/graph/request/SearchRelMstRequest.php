<?php

/**
 * 時系列検索処理の値を保持する
 */
class SearchRelMstRequest {
    private $rel_mst_Id;
    private $rel_mst_Name;
    private $opusId;
    private $userId;
    private $offset = 0;
    private $limit = 100;
    private $errorMsg = array();

    /**
     * 時系列検索処理の値を格納します
     */
    public function __construct() {}

    public function getRelMstId() {
        return $this->rel_mst_Id;
    }

    public function setRelMstId($rel_mst_Id) {
        $this->rel_mst_Id = $rel_mst_Id;
    }

    public function getRelMstName() {
        return $this->rel_mst_Name;
    }

    public function setRelMstName($rel_mst_Name) {
        $this->rel_mst_Name = $rel_mst_Name;
    }

    public function getOpusId() {
        return $this->opusId;
    }

    public function setOpusId($opusId) {
        $this->opusId = $opusId;
    }

    public function getOffset() {
        return $this->offset;
    }

    public function setOffset($offset) {
        $this->offset = $offset;
    }

    public function getLimit() {
        return $this->limit;
    }

    public function setLimit($limit) {
        $this->limit = $limit;
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

            // ユーザIDの文字数チェック
            if (strlen($this->userId) != Constant::USER_ID_DIGIT + strlen(Constant::USER_ID_STR)) {
                array_push($this->errorMsg, 'エラー ：ユーザIDは'.Constant::USER_ID_DIGIT + strlen(Constant::USER_ID_STR).'文字で入力してください');
                $validationFlg = true;
            }
        } catch (Exception $e) {
            $validationFlg = true;
        }

        return $validationFlg;
    }
}
