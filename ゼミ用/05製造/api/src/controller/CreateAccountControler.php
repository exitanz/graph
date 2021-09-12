<?php
require_once dirname(__FILE__) . '/../request/CreateAccountRequest.php';
require_once dirname(__FILE__) . '/../service/AccountService.php';

// 変数
$msg = '';

// リクエストの値を格納
$createAccountRequest = new CreateAccountRequest($_POST['user_name'], $_POST['password']);

// バリデーションチェック
if (!$createAccountRequest->validation()) {
    // 新規登録
    $accountService = new AccountService();
    $msg = $accountService->createAccount($createAccountRequest->getUserName(), $createAccountRequest->getPassword());
} else {
    $msg = $createAccountRequest->getErrorMsg();
}

// レスポンスに値を格納
$_SESSION['create_account_msg'] = $createAccountRequest->getErrorMsg() . $msg;

// リダイレクトを実行
header("Location: ../../../web/create.php");
