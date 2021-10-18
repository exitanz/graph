<?php
require_once dirname(__FILE__) . '/../common/Constant.php';

/**
 * 関係削除処理の値を保持する
 */
class DeleteRelRequest {
    private $relId;
    private $opusId;
    private $userId;
    private $errorMsg = array();

    /**
     * 関係削除処理の値を格納します
     */
    public function __construct($relId, $userId) {
        $this->relId = $relId;
        $this->userId = $userId;
    }

    public function getRelId() {
        return $this->relId;
    }

    public function getOpusId() {
        return $this->opusId;
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
            if (empty($this->relId)) {
                array_push($this->errorMsg, 'エラー ：必須項目が入力されていません');
                $validationFlg = true;
            }

            // 関係IDの文字数チェック
            if (strlen($this->relId) != Constant::REL_ID_DIGIT + strlen(Constant::REL_ID_STR)) {
                array_push($this->errorMsg, 'エラー ：関係IDは' . Constant::REL_ID_DIGIT + strlen(Constant::REL_ID_STR) . '文字で入力してください');
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
