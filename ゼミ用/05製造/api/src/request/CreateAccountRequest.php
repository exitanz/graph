<?php

/**
 * アカウント登録処理の値を保持する
 */
class CreateAccountRequest {
    private $userName;
    private $password;
    private $errorMsg = '';

    /**
     * アカウント登録処理の値を格納します
     */
    public function __construct($userName, $password) {
        $this->userName = $userName;
        $this->password = $password;
    }

    public function getUserName() {
        return $this->userName;
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
        if (20 < strlen($this->userName)) {
            $this->errorMsg .= '<div class="alert alert-danger"><strong>エラー ：</strong> ユーザ名は20文字以内で入力してください<br /></div>';
            $validationFlg = true;
        }

        // パスワードの文字数チェック
        if (20 < strlen($this->password)) {
            $this->errorMsg .= '<div class="alert alert-danger"><strong>エラー ：</strong> パスワードは20文字以内で入力してください<br /></div>';
            $validationFlg = true;
        }

        // 入力項目チェック
        if (empty($this->userName) || empty($this->password)) {
            $this->errorMsg .= '<div class="alert alert-danger"><strong>エラー ：</strong> 必須項目が入力されていません<br /></div>';
            $validationFlg = true;
        }

        return $validationFlg;
    }
}
