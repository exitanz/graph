<?php

/**
 * 作品登録処理の値を保持する
 */
class CreateActorRequest {
    private $actorName;
    private $actorInfo;
    private $actorImg;
    private $opusId;
    private $timeId;
    private $groupId;
    private $userId;
    private $errorMsg = array();

    /**
     * 作品登録処理の値を格納します
     */

    public function __construct() {
    }

    public function getActorName() {
        return $this->actorName;
    }

    public function setActorName($actorName) {
        $this->actorName = $actorName;
    }

    public function getActorInfo() {
        return $this->actorInfo;
    }

    public function setActorInfo($actorInfo) {
        $this->actorInfo = $actorInfo;
    }

    public function getActorImg() {
        return $this->actorImg;
    }

    public function setActorImg($actorImg) {
        $this->actorImg = $actorImg;
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

    public function getGroupId() {
        return $this->groupId;
    }

    public function setGroupId($groupId) {
        $this->groupId = $groupId;
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
            if (empty($this->actorName) || empty($this->opusId) || empty($this->timeId) || empty($this->groupId) || empty($this->userId)) {
                array_push($this->errorMsg, 'エラー ：必須項目が入力されていません');
                $validationFlg = true;
            }

            // 登場人物名の文字数チェック
            if (100 < strlen($this->actorName)) {
                array_push($this->errorMsg, 'エラー ：登場人物名は100文字以内で入力してください');
                $validationFlg = true;
            }

            // 登場人物説明の文字数チェック
            if (2000 < strlen($this->actorInfo)) {
                array_push($this->errorMsg, 'エラー ：登場人物説明は1200文字以内で入力してください');
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
