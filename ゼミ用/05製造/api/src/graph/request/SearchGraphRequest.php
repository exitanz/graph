<?php

/**
 * グラフ検索処理の値を保持する
 */
class SearchGraphRequest {
    private $timeId;
    private $opusId;
    private $errorMsg = array();

    /**
     * グラフ検索処理の値を格納します
     */
    public function __construct() {
    }

    public function getTimeId() {
        return $this->timeId;
    }

    public function setTimeId($timeId) {
        $this->timeId = $timeId;
    }

    public function getOpusId() {
        return $this->opusId;
    }

    public function setOpusId($opusId) {
        $this->opusId = $opusId;
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
            if (empty($this->opusId) || empty($this->timeId)) {
                array_push($this->errorMsg, 'エラー ：必須項目が入力されていません');
                $validationFlg = true;
            }

            // 作品IDの文字数チェック
            if (strlen($this->opusId) != Constant::OPUS_ID_DIGIT + strlen(Constant::OPUS_ID_STR)) {
                array_push($this->errorMsg, 'エラー ：作品IDは'.Constant::OPUS_ID_DIGIT + strlen(Constant::OPUS_ID_STR).'文字で入力してください');
                $validationFlg = true;
            }

            // 時系列IDの文字数チェック
            if (strlen($this->timeId) != Constant::TIME_ID_DIGIT + strlen(Constant::TIME_ID_STR)) {
                array_push($this->errorMsg, 'エラー ：時系列IDは' . Constant::TIME_ID_DIGIT + strlen(Constant::TIME_ID_STR) . '文字で入力してください');
                $validationFlg = true;
            }
        } catch (Exception $e) {
            $validationFlg = true;
        }

        return $validationFlg;
    }
}
