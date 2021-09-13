<?php
require_once dirname(__FILE__) . '/../request/CreateAccountRequest.php';
require_once dirname(__FILE__) . '/../service/AccountService.php';
require_once dirname(__FILE__) . '/../common/ResultCode.php';
// ヘッダーを指定
header("Content-Type: application/json; charset=utf-8");

// 変数
$resultCode = ResultCode::CODE000;
$msg = array();

try {
    // リクエスト取得
    $REQUEST = json_decode(file_get_contents("php://input"), true);

    // リクエストの値を確認
    if (empty($REQUEST['user_name']) || empty($REQUEST['password'])) {
        // リクエストエラー
        http_response_code(400);
        $resultCode = ResultCode::CODE101;
        throw new Exception('リクエストの値が不正です。');
    }

    // リクエストの値を格納
    $createAccountRequest = new CreateAccountRequest($REQUEST['user_name'], $REQUEST['password']);

    // バリデーションチェック
    if ($createAccountRequest->validation()) {
        // バリデーション違反
        http_response_code(400);
        $resultCode = ResultCode::CODE101;
        $msg = $createAccountRequest->getErrorMsg();
        throw new Exception();
    }

    // 新規登録
    $accountService = new AccountService();
    array_push($msg, $accountService->createAccount($createAccountRequest->getUserName(), $createAccountRequest->getPassword()));
} catch (Exception $e) {
    if(!empty($e->getMessage())){
        array_push($msg, $e->getMessage());
    }
}

// レスポンスに値を格納
$response = array(
    "resultCode" => $resultCode,
    "msg" => $msg
);

// レスポンス表示
echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
