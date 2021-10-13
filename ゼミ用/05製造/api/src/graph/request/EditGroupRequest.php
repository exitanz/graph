<?php

/**
 * グループ編集処理の値を保持する
 */
class EditGroupRequest {
    private $groupId;
    private $groupName;
    private $groupInfo;
    private $groupColor;
    private $userId;
    private $version = 0;
    private $errorMsg = array();

    /**
     * グループ編集処理の値を格納します
     */
    public function __construct() {
    }

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

    public function getGroupColor() {
        return $this->groupColor;
    }

    public function setGroupColor($groupColor) {
        $this->groupColor = $groupColor;
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
            if (empty($this->groupId)) {
                array_push($this->errorMsg, 'エラー ：必須項目が入力されていません');
                $validationFlg = true;
            }

            // グループIDの文字数チェック
            if (strlen($this->groupId) != Constant::GROUP_ID_DIGIT + strlen(Constant::GROUP_ID_STR)) {
                array_push($this->errorMsg, 'エラー ：グループIDは' . Constant::GROUP_ID_DIGIT + strlen(Constant::GROUP_ID_STR) . '文字で入力してください');
                $validationFlg = true;
            }

            // ユーザIDの文字数チェック
            if (strlen($this->userId) != Constant::USER_ID_DIGIT + strlen(Constant::USER_ID_STR)) {
                array_push($this->errorMsg, 'エラー ：ユーザIDは' . Constant::USER_ID_DIGIT + strlen(Constant::USER_ID_STR) . '文字で入力してください');
                $validationFlg = true;
            }

            // グループ名の文字数チェック
            if (!empty($this->groupName)  && 100 < strlen($this->groupName)) {
                array_push($this->errorMsg, 'エラー ：グループ名は100文字以内で入力してください');
                $validationFlg = true;
            }

            // グループ詳細の文字数チェック
            if (!empty($this->groupInfo) && 1200 < strlen($this->groupInfo)) {
                array_push($this->errorMsg, 'エラー ：グループ詳細は1200文字以内で入力してください');
                $validationFlg = true;
            }

            // グループ色の文字数チェック
            if (!empty($this->groupColor) && 100 < strlen($this->groupColor)) {
                array_push($this->errorMsg, 'エラー ：グループ色は100文字以内で入力してください');
                $validationFlg = true;
            }
        } catch (Exception $e) {
            $validationFlg = true;
        }

        return $validationFlg;
    }
}
