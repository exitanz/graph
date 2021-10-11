<?php

/**
 * 作品編集処理の値を保持する
 */
class EditOpusRequest {
    private $opusId;
    private $opusName;
    private $userId;
    private $version = 0;
    private $errorMsg = array();

    /**
     * 作品編集処理の値を格納します
     */
    public function __construct() {
    }

    public function getOpusId() {
        return $this->opusId;
    }

    public function setOpusId($opusId) {
        $this->opusId = $opusId;
    }

    public function getOpusName() {
        return $this->opusName;
    }

    public function setOpusName($opusName) {
        $this->opusName = $opusName;
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
            if (empty($this->opusName) || empty($this->opusId)) {
                array_push($this->errorMsg, 'エラー ：必須項目が入力されていません');
                $validationFlg = true;
            }

            // 作品名の文字数チェック
            if (100 < strlen($this->opusName)) {
                array_push($this->errorMsg, 'エラー ：作品名は100文字以内で入力してください');
                $validationFlg = true;
            }

            // 作品IDの文字数チェック
            if (strlen($this->opusId) != Constant::OPUS_ID_DIGIT + strlen(Constant::OPUS_ID_STR)) {
                array_push($this->errorMsg, 'エラー ：作品IDは'.Constant::OPUS_ID_DIGIT + strlen(Constant::OPUS_ID_STR).'文字で入力してください');
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
