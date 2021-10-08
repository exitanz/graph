<?php

/**
 * グループ登録処理の値を保持する
 */
class CreateGroupRequest {
    private $groupName;
    private $groupInfo;
    private $opusId;
    private $timeId;
    private $userId;
    private $errorMsg = array();

    /**
     * グループ登録処理の値を格納します
     */

    public function __construct() {
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
            if (empty($this->groupName) || empty($this->opusId)|| empty($this->timeId)) {
                array_push($this->errorMsg, 'エラー ：必須項目が入力されていません');
                $validationFlg = true;
            }

            // グループ名の文字数チェック
            if (100 < strlen($this->groupName)) {
                array_push($this->errorMsg, 'エラー ：グループ名は100文字以内で入力してください');
                $validationFlg = true;
            }

            // グループ詳細の文字数チェック
            if (!empty($this->groupInfo) && 1200 < strlen($this->groupInfo)) {
                array_push($this->errorMsg, 'エラー ：グループ詳細は1200文字以内で入力してください');
                $validationFlg = true;
            }

            // 作品IDの文字数チェック
            if (strlen($this->opusId) != Constant::OPUS_ID_DIGIT + strlen(Constant::OPUS_ID_STR)) {
                array_push($this->errorMsg, 'エラー ：グループIDは8文字で入力してください');
                $validationFlg = true;
            }

            // 時系列IDの文字数チェック
            if (strlen($this->timeId) != Constant::OPUS_ID_DIGIT + strlen(Constant::OPUS_ID_STR)) {
                array_push($this->errorMsg, 'エラー ：時系列IDは8文字で入力してください');
                $validationFlg = true;
            }

            // ユーザIDの文字数チェック
            if (strlen($this->userId) != Constant::USER_ID_DIGIT + strlen(Constant::USER_ID_STR)) {
                array_push($this->errorMsg, 'エラー ：ユーザIDは10文字で入力してください');
                $validationFlg = true;
            }
        } catch (Exception $e) {
            $validationFlg = true;
        }

        return $validationFlg;
    }
}
