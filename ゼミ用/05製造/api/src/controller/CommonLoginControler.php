<?php
require_once dirname(__FILE__).'/../request/LoginRequest.php';
require_once dirname(__FILE__).'/../service/LoginService.php';

/**
 * ログイン確認クラス
 */
class CommonLoginControler {
    public static function commonLogin($userId, $password) {

        // 引数の値を格納
        $loginRequest = new LoginRequest($userId, $password);

        // バリデーションチェック
        if (!$loginRequest->validation()) {
            // ログイン
            $loginService = new LoginService();
            return $loginService->confirmation($userId, $password);
        }

        return false;
    }
}
