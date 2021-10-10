<?php
require_once dirname(__FILE__) . '/../common/Constant.php';

/**
 * 関係性削除処理の値を保持する
 */
class DeleteRelMstRequest {
    private $relMstId;
    private $opusId;
    private $userId;
    private $version;
    private $errorMsg = array();

    /**
     * 関係性削除処理の値を格納します
     */
    public function __construct($relMstId, $userId) {
        $this->relMstId = $relMstId;
        $this->userId = $userId;
    }

    public function getrelMstId() {
        return $this->relMstId;
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
            if (empty($this->relMstId) || 
            empty($this->opusId) || 
            empty($this->userId) || 
            empty($this->version)) {
                array_push($this->errorMsg, 'エラー ：必須項目が入力されていません');
                $validationFlg = true;
            }

            // 関係性IDの文字数チェック
            if (strlen($this->relMstId) != Constant::REL_MST_ID_DIGIT + strlen(Constant::REL_MST_ID_STR)) {
                array_push($this->errorMsg, 'エラー ：関係性IDは'.Constant::REL_MST_ID_DIGIT + strlen(Constant::REL_MST_ID_STR).'文字で入力してください');
                $validationFlg = true;
            }

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
