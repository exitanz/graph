<?php

/**
 * 時系列検索処理の値を保持する
 */
class SearchActorRequest {
    private $actorId;
    private $actorName;
    private $actorInfo;
    private $opusId;
    private $timeId;
    private $groupId;
    private $userId;
    private $offset = 0;
    private $limit = 100;
    private $errorMsg = array();

    /**
     * 時系列検索処理の値を格納します
     */
    public function __construct() {
    }

    public function getActorId() {
        return $this->actorId;
    }

    public function setActorId($actorId) {
        $this->actorId = $actorId;
    }

    public function getActorName() {
        return $this->actorName;
    }

    public function setActorName($actorName) {
        $this->actorName = $actorName;
    }

    public function getActorInfo() {
        return $this->actorInfo;
    }

    public function setActorInfo($actorInfo) {
        $this->actorInfo = $actorInfo;
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

    public function getGroupId() {
        return $this->groupId;
    }

    public function setGroupId($groupId) {
        $this->groupId = $groupId;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
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
