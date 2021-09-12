<?php
require_once dirname(__FILE__) . '/../request/CreateAccountRequest.php';
require_once dirname(__FILE__) . '/../service/AccountService.php';
require_once dirname(__FILE__) . '/../common/ResultCode.php';

// 変数
$resultCode = ResultCode::CODE000;
$msg = array();

// リクエストの値を格納
$createAccountRequest = new CreateAccountRequest($_POST['user_name'], $_POST['password']);

// バリデーションチェック
if (!$createAccountRequest->validation()) {
    // 新規登録
    $accountService = new AccountService();
    array_push($msg, $accountService->createAccount($createAccountRequest->getUserName(), $createAccountRequest->getPassword()));
} else {
    // バリデーション違反
    http_response_code(400);
    $resultCode = ResultCode::CODE101;
    array_push($msg, $createAccountRequest->getErrorMsg());
}

// レスポンスに値を格納
$response = array(
    "resultCode" => $resultCode,
    "msg" => $msg
);

// レスポンス表示
echo json_encode($response, JSON_PRETTY_PRINT);
