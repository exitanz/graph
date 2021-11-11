<?php
require_once dirname(__FILE__) . '/../request/LoginRequest.php';
require_once dirname(__FILE__) . '/../service/LoginService.php';
require_once dirname(__FILE__) . '/../common/ResultCode.php';
// ヘッダーを指定
header("Content-Type: application/json; charset=utf-8");

// 変数
$resultCode = ResultCode::CODE000;
$msg = array();
$optional = array();

try {
    if(strcmp((string)$_SERVER['REQUEST_METHOD'], 'POST') != 0){
        // メソッドエラー
        http_response_code(404);
        $resultCode = ResultCode::CODE104;
        throw new Exception('メソッドが存在しません。');
    }
    
    // リクエスト取得
    $REQUEST = json_decode(file_get_contents("php://input"), true);

    // リクエストの値を確認
    if (empty($REQUEST['user_id']) || empty($REQUEST['password'])) {
        // リクエストエラー
        http_response_code(400);
        $resultCode = ResultCode::CODE101;
        throw new Exception('リクエストの値が不正です。');
    }

    // リクエストの値を格納
    $loginRequest = new LoginRequest($REQUEST['user_id'], $REQUEST['password']);

    // バリデーションチェック
    if ($loginRequest->validation()) {
        // バリデーション違反
        http_response_code(400);
        $resultCode = ResultCode::CODE101;
        $msg = $loginRequest->getErrorMsg();
        throw new Exception();
    }

    // ログイン
    try {
        $loginService = new LoginService();
        $optional = $loginService->login($loginRequest->getUserId(), $loginRequest->getPassword());
        array_push($msg, "認証に成功しました。");
    } catch (Exception $e) {
        // リクエストエラー
        http_response_code(404);
        $resultCode = ResultCode::CODE102;
        throw $e;
    }
} catch (Exception $e) {
    if(!empty($e->getMessage())){
        array_push($msg, $e->getMessage());
    }
}

// レスポンスに値を格納
$response = array(
    "resultCode" => $resultCode,
    "msg" => $msg,
    "optional" => $optional
);

// レスポンス表示
echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
