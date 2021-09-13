<?php
require_once dirname(__FILE__) . '/../common/Constant.php';

/**
 * アカウント登録処理の値を保持する
 */
class LoginRequest {
    private $userId;
    private $password;
    private $errorMsg = array();

    /**
     * アカウント登録処理の値を格納します
     */
    public function __construct($userId, $password) {
        $this->userId = $userId;
        $this->password = $password;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getErrorMsg() {
        return $this->errorMsg;
    }

    /**
     * バリデーションチェックをします
     */
    public function validation() {
        $validationFlg = false;

        // ユーザ名の文字数チェック
        if (strlen($this->userId) != Constant::USER_ID_DIGIT + strlen(Constant::USER_ID_STR)) {
            array_push($this->errorMsg, 'エラー ：ユーザIDは8文字で入力してください');
            $validationFlg = true;
        }

        // パスワードの文字数チェック
        if (20 < strlen($this->password)) {
            array_push($this->errorMsg, 'エラー ：パスワードは20文字以内で入力してください');
            $validationFlg = true;
        }

        // 入力項目チェック
        if (empty($this->userId) || empty($this->password)) {
            array_push($this->errorMsg, 'エラー ：ユーザIDまたはパスワードが入力されていません');
            $validationFlg = true;
        }

        return $validationFlg;
    }
}
