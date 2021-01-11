<?php
require_once dirname(__FILE__).'/../request/CreateAccountRequest.php';
require_once dirname(__FILE__).'/../service/CreateAccountService.php';

// セッション開始
if (!isset($_SESSION)) {
    session_start();
}
unset ($_SESSION['create_account_msg']);

// 変数
$msg = '';

// リクエストの値を格納
$createAccountRequest = new CreateAccountRequest($_POST['user_name'], $_POST['password']);

// バリデーションチェック
if (!$createAccountRequest->validation()) {
    // 新規登録
    $createAccountService = new CreateAccountService();
    $msg = $createAccountService->createAccount($createAccountRequest->getUserName(), $createAccountRequest->getPassword());
}

// セッションに値を格納
$_SESSION['create_account_msg'] = $createAccountRequest->getErrorMsg() . $msg;

// リダイレクトを実行
header("Location: ../../../web/create.php");
