<?php
require_once dirname(__FILE__) . '/../common/Constant.php';

/**
 * 作品削除処理の値を保持する
 */
class DeleteOpusRequest {
    private $opusId;
    private $userId;
    private $version;
    private $errorMsg = array();

    /**
     * 作品削除処理の値を格納します
     */
    public function __construct($opusId, $userId) {
        $this->opusId = $opusId;
        $this->userId = $userId;
    }

    public function getopusId() {
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
            if (empty($this->opusId)) {
                array_push($this->errorMsg, 'エラー ：必須項目が入力されていません');
                $validationFlg = true;
            }

            // 作品IDの文字数チェック
            if (strlen($this->opusId) != Constant::OPUS_ID_DIGIT + strlen(Constant::OPUS_ID_STR)) {
                array_push($this->errorMsg, 'エラー ：作品IDは'.Constant::OPUS_ID_DIGIT + strlen(Constant::OPUS_ID_STR).'文字で入力してください');
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
