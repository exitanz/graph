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
    if(strcmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
        // メソッドエラー
        http_response_code(404);
        $resultCode = ResultCode::CODE104;
        throw new Exception('メソッドが存在しません。');
    }

    // リクエスト取得
    $REQUEST = json_decode(file_get_contents("php://input"), true);

    // リクエストの値を確認、バリデーションチェック
    if (empty($REQUEST['user_id']) || empty($REQUEST['token'])) {
        // リクエストエラー
        http_response_code(400);
        $resultCode = ResultCode::CODE101;
        throw new Exception('リクエストの値が不正です。');
    }

    // ログイン確認
    try {
        $loginService = new LoginService();
        if (!$loginService->confirmation($REQUEST['user_id'], $REQUEST['token'])) {
            throw new Exception('ログイン状態を確認できませんでした。');
        }
        array_push($msg, "ログイン状態が確認できました。");
    } catch (Exception $e) {
        // ログイン未確認エラー
        http_response_code(404);
        $resultCode = ResultCode::CODE102;
        throw $e;
    }
} catch (Exception $e) {
    if (!empty($e->getMessage())) {
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
