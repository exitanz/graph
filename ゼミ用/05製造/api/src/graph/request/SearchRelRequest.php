<?php

/**
 * 時系列検索処理の値を保持する
 */
class SearchRelRequest {
    private $relId;
    private $relMstId;
    private $relMstInfo;
    private $actorId;
    private $targetId;
    private $opusId;
    private $timeId;
    private $userId;
    private $offset = 0;
    private $limit = 100;
    private $errorMsg = array();

    /**
     * 時系列検索処理の値を格納します
     */
    public function __construct() {
    }

    public function getRelId() {
        return $this->relId;
    }

    public function setRelId($relId) {
        $this->relId = $relId;
    }

    public function getRelMstId() {
        return $this->relMstId;
    }

    public function setRelMstId($relMstId) {
        $this->relMstId = $relMstId;
    }

    public function getRelMstInfo() {
        return $this->relMstInfo;
    }

    public function setRelMstInfo($relMstInfo) {
        $this->relMstInfo = $relMstInfo;
    }

    public function getActorId() {
        return $this->actorId;
    }

    public function setActorId($actorId) {
        $this->actorId = $actorId;
    }

    public function getTargetId() {
        return $this->targetId;
    }

    public function setTargetId($targetId) {
        $this->targetId = $targetId;
    }

    public function getOpusId() {
        return $this->opusId;
    }

    public function setOpusId($opusId) {
        $this->opusId = $opusId;
    }

    public function getTimeId() {
        return $this->timeId;
    }

    public function setTimeId($timeId) {
        $this->timeId = $timeId;
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
                array_push($this->errorMsg, 'エラー ：ユーザIDは' . Constant::USER_ID_DIGIT + strlen(Constant::USER_ID_STR) . '文字で入力してください');
                $validationFlg = true;
            }
        } catch (Exception $e) {
            $validationFlg = true;
        }

        return $validationFlg;
    }
}
