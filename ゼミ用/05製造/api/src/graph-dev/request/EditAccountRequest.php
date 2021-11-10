<?php

/**
 * ユーザ編集処理の値を保持する
 */
class EditAccountRequest
{
    private $userId;
    private $userName;
    private $password;
    private $version;
    private $errorMsg = array();

    /**
     * ユーザ編集処理の値を格納します
     */
    public function __construct()
    {
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function setVersion($version)
    {
        $this->version = $version;
    }

    public function getErrorMsg()
    {
        return $this->errorMsg;
    }

    /**
     * バリデーションチェックをします
     */
    public function validation()
    {
        $validationFlg = false;

        try {
            // 入力項目チェック
            if (empty($this->userId)) {
                array_push($this->errorMsg, 'エラー ：必須項目が入力されていません');
                $validationFlg = true;
            }

            // ユーザIDの文字数チェック
            if (strlen($this->userId) != Constant::USER_ID_DIGIT + strlen(Constant::USER_ID_STR)) {
                array_push($this->errorMsg, 'エラー ：ユーザIDは' . Constant::USER_ID_DIGIT + strlen(Constant::USER_ID_STR) . '文字で入力してください');
                $validationFlg = true;
            }

            // ユーザ名の文字数チェック
            if (100 < strlen($this->userName)) {
                array_push($this->errorMsg, 'エラー ：ユーザ名は100文字以内で入力してください');
                $validationFlg = true;
            }

            // パスワードの文字数チェック
            if (20 < strlen($this->password)) {
                array_push($this->errorMsg, 'エラー ：パスワードは20文字以内で入力してください');
                $validationFlg = true;
            }
        } catch (Exception $e) {
            $validationFlg = true;
        }

        return $validationFlg;
    }
}
