<?php
require_once dirname(__FILE__) . '/../common/Constant.php';

/**
 * 時系列削除処理の値を保持する
 */
class DeleteTimeRequest {
    private $timeId;
    private $userId;
    private $errorMsg = array();

    /**
     * 時系列削除処理の値を格納します
     */
    public function __construct($timeId, $userId) {
        $this->timeId = $timeId;
        $this->userId = $userId;
    }

    public function getTimeId() {
        return $this->timeId;
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
            if (empty($this->timeId) || empty($this->userId)) {
                array_push($this->errorMsg, 'エラー ：必須項目が入力されていません');
                $validationFlg = true;
            }

            // 時系列IDの文字数チェック
            if (strlen($this->timeId) != Constant::TIME_ID_DIGIT + strlen(Constant::TIME_ID_STR)) {
                array_push($this->errorMsg, 'エラー ：時系列IDは' . Constant::TIME_ID_DIGIT + strlen(Constant::TIME_ID_STR) . '文字で入力してください');
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
