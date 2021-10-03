<?php
require_once dirname(__FILE__) . '/../common/Constant.php';

/**
 * アカウント削除処理の値を保持する
 */
class DeleteAccountRequest {
    private $userId;
    private $errorMsg = array();

    /**
     * アカウント削除処理の値を格納します
     */
    public function __construct($userId) {
        $this->userId = $userId;
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
            if (empty($this->userId)) {
                array_push($this->errorMsg, 'エラー ：ユーザIDまたはパスワードが入力されていません');
                $validationFlg = true;
            }

            // ユーザIDの文字数チェック
            if (strlen($this->userId) != Constant::USER_ID_DIGIT + strlen(Constant::USER_ID_STR)) {
                array_push($this->errorMsg, 'エラー ：ユーザIDは8文字で入力してください');
                $validationFlg = true;
            }
        } catch (Exception $e) {
            $validationFlg = true;
        }

        return $validationFlg;
    }
}
