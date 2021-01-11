<?php
require_once dirname(__FILE__).'/../request/LoginRequest.php';
require_once dirname(__FILE__).'/../service/LoginService.php';

// セッション開始
if (!isset($_SESSION)) {
    session_start();
}
unset ($_SESSION['login_msg']);

// 変数
$msg = '';
$flg = false;

// リクエストの値を格納
$loginRequest = new LoginRequest($_POST['user_id'], $_POST['password']);

// バリデーションチェック
if (!$loginRequest->validation()) {
    // ログイン
    $loginService = new LoginService();
    $flg = $loginService->login($loginRequest->getUserId(), $loginRequest->getPassword());
}

// セッションに値を格納
$_SESSION['login_msg'] = $loginRequest->getErrorMsg() . $msg;

if($flg){
    // ログイン成功
    header("Location: ../../../web/menu.php");
}else{
    // ログイン失敗
    header("Location: ../../../web/login.php");
}

