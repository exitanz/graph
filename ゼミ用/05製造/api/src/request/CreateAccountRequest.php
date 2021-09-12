<?php

/**
 * アカウント登録処理の値を保持する
 */
class CreateAccountRequest {
    private $userName;
    private $password;
    private $errorMsg = array();

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
            array_push($this->errorMsg, 'エラー ：ユーザ名は20文字以内で入力してください');
            $validationFlg = true;
        }

        // パスワードの文字数チェック
        if (20 < strlen($this->password)) {
            array_push($this->errorMsg, 'エラー ：パスワードは20文字以内で入力してください');
            $validationFlg = true;
        }

        // 入力項目チェック
        if (empty($this->userName) || empty($this->password)) {
            array_push($this->errorMsg, 'エラー ：必須項目が入力されていません');
            $validationFlg = true;
        }

        return $validationFlg;
    }
}
