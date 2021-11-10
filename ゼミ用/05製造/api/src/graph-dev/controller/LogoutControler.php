<?php
require_once dirname(__FILE__) . '/../request/LoginRequest.php';
require_once dirname(__FILE__) . '/../service/LoginService.php';
require_once dirname(__FILE__) . '/../common/ResultCode.php';
// ヘッダーを指定
header("Content-Type: application/json; charset=utf-8");

// 変数
$resultCode = ResultCode::CODE000;
$msg = array();

try {
    if(strcmp((string)$_SERVER['REQUEST_METHOD'], 'GET') != 0){
        // メソッドエラー
        http_response_code(404);
        $resultCode = ResultCode::CODE104;
        throw new Exception('メソッドが存在しません。');
    }

    // リクエストの値を確認、バリデーションチェック
    if (empty($_GET["user_id"])) {
        // リクエストエラー
        http_response_code(400);
        $resultCode = ResultCode::CODE101;
        throw new Exception('リクエストの値が不正です。');
    }
    // ログアウト
    setcookie("token[" . $_GET["user_id"] . "]", "", time() - 60);
    array_push($msg, "認証解除に成功しました。");
} catch (Exception $e) {
    array_push($msg, '認証解除に失敗しました');
}

// レスポンスに値を格納
$response = array(
    "resultCode" => $resultCode,
    "msg" => $msg
);

// レスポンス表示
echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
