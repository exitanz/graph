<?php

/**
 * アカウント登録処理の値を保持する
 */
class LoginRequest {
    private $userId;
    private $password;
    private $errorMsg = '';

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
        if (strlen($this->userId) != 8) {
            $this->errorMsg .= '<div class="alert alert-danger"><strong>エラー ：</strong> ユーザIDは8文字で入力してください<br /></div>';
            $validationFlg = true;
        }

        // パスワードの文字数チェック
        if (20 < strlen($this->password)) {
            $this->errorMsg .= '<div class="alert alert-danger"><strong>エラー ：</strong> パスワードは20文字以内で入力してください<br /></div>';
            $validationFlg = true;
        }

        // 入力項目チェック
        if (empty($this->userId) || empty($this->password)) {
            $this->errorMsg .= '<div class="alert alert-danger"><strong>エラー ：</strong> ユーザIDまたはパスワードが入力されていません<br /></div>';
            $validationFlg = true;
        }

        return $validationFlg;
    }
}
