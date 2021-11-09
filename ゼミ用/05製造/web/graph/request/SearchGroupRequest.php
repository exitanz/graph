<?php

/**
 * グループ検索処理の値を保持する
 */
class SearchGroupRequest {
    private $groupId;
    private $groupName;
    private $groupInfo;
    private $opusId;
    private $timeId;
    private $userId;
    private $offset = 0;
    private $limit = 100;
    private $errorMsg = array();

    /**
     * グループ検索処理の値を格納します
     */
    public function __construct() {}

    public function getGroupId() {
        return $this->groupId;
    }

    public function setGroupId($groupId) {
        $this->groupId = $groupId;
    }

    public function getGroupName() {
        return $this->groupName;
    }

    public function setGroupName($groupName) {
        $this->groupName = $groupName;
    }

    public function getGroupInfo() {
        return $this->groupInfo;
    }

    public function setGroupInfo($groupInfo) {
        $this->groupInfo = $groupInfo;
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
