<?php
require_once dirname(__FILE__) . '/../common/Constant.php';

/**
 * グループ削除処理の値を保持する
 */
class DeleteGroupRequest {
    private $groupId;
    private $userId;
    private $errorMsg = array();

    /**
     * グループ削除処理の値を格納します
     */
    public function __construct($groupId, $userId) {
        $this->groupId = $groupId;
        $this->userId = $userId;
    }

    public function getGroupId() {
        return $this->groupId;
    }

    public function getUserId() {
        return $this->userId;
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
        } catch (Exception $e) {
            $validationFlg = true;
        }

        return $validationFlg;
    }
}
