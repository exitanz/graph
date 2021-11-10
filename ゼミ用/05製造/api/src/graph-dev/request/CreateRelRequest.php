<?php

/**
 * 作品登録処理の値を保持する
 */
class CreateRelRequest {
    private $relMstId;
    private $relMstInfo;
    private $actorId;
    private $targetId;
    private $opusId;
    private $timeId;
    private $userId;
    private $errorMsg = array();

    /**
     * 作品登録処理の値を格納します
     */

    public function __construct() {
    }

    public function getRelMstId() {
        return $this->relMstId;
    }

    public function setRelMstId($relMstId) {
        $this->relMstId = $relMstId;
    }

    public function getRelMstInfo() {
        return $this->relMstInfo;
    }

    public function setRelMstInfo($relMstInfo) {
        $this->relMstInfo = $relMstInfo;
    }

    public function getActorId() {
        return $this->actorId;
    }

    public function setActorId($actorId) {
        $this->actorId = $actorId;
    }

    public function getTargetId() {
        return $this->targetId;
    }

    public function setTargetId($targetId) {
        $this->targetId = $targetId;
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
            if (empty($this->relMstId) || empty($this->actorId) || empty($this->targetId) || empty($this->opusId) || empty($this->timeId)) {
                array_push($this->errorMsg, 'エラー ：必須項目が入力されていません');
                $validationFlg = true;
            }

            // 関係性IDの文字数チェック
            if (strlen($this->relMstId) != Constant::REL_MST_ID_DIGIT + strlen(Constant::REL_MST_ID_STR)) {
                array_push($this->errorMsg, 'エラー ：関係性IDは' . Constant::REL_MST_ID_DIGIT + strlen(Constant::REL_MST_ID_STR) . '文字で入力してください');
                $validationFlg = true;
            }

            // 関係詳細の文字数チェック
            if (100 < strlen($this->relMstInfo)) {
                array_push($this->errorMsg, 'エラー ：関係詳細は1200文字以内で入力してください');
                $validationFlg = true;
            }

            // 登場人物IDの文字数チェック
            if (strlen($this->actorId) != Constant::ACTOR_ID_DIGIT + strlen(Constant::ACTOR_ID_STR)) {
                array_push($this->errorMsg, 'エラー ：登場人物IDは' . Constant::ACTOR_ID_DIGIT + strlen(Constant::ACTOR_ID_STR) . '文字で入力してください');
                $validationFlg = true;
            }

            // 作品IDの文字数チェック
            if (strlen($this->opusId) != Constant::OPUS_ID_DIGIT + strlen(Constant::OPUS_ID_STR)) {
                array_push($this->errorMsg, 'エラー ：作品IDは' . Constant::OPUS_ID_DIGIT + strlen(Constant::OPUS_ID_STR) . '文字で入力してください');
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
