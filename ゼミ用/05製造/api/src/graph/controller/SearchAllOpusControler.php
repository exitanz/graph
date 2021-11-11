<?php
require_once dirname(__FILE__) . '/../service/OpusService.php';
require_once dirname(__FILE__) . '/../service/LoginService.php';
require_once dirname(__FILE__) . '/../common/ResultCode.php';
// ヘッダーを指定
header("Content-Type: application/json; charset=utf-8");

// 変数
$resultCode = ResultCode::CODE000;
$msg = array();
$optional = array();

try {
    // メソッド確認
    if (strcmp((string)$_SERVER['REQUEST_METHOD'], 'GET') != 0) {
        // メソッドエラー
        http_response_code(404);
        $resultCode = ResultCode::CODE104;
        throw new Exception('メソッドが存在しません。');
    }

    // 認証確認
    if (empty($_GET['user_id']) || empty($_GET['token']) || !(new LoginService())->confirmation($_GET['user_id'], $_GET['token'])) {
        // 認証エラー
        http_response_code(403);
        $resultCode = ResultCode::CODE103;
        throw new Exception('認証されていません');
    }

    // リクエスト代入
    $userName = null;
    $opusName = null;
    $offset = 0;
    $limit = 100;

    // リクエストチェック
    if (!empty($_REQUEST['user_name'])) $userName = $_REQUEST['user_name'];
    if (!empty($_REQUEST['opus_name'])) $opusName = $_REQUEST['opus_name'];
    if (!empty($_REQUEST['offset'])) $offset = $_REQUEST['offset'];
    if (!empty($_REQUEST['limit'])) $limit = $_REQUEST['limit'];

    try {
        // 検索
        $opusService = new OpusService();
        $optional = $opusService->searchAllOpus($userName, $opusName, $offset, $limit);
        array_push($msg, "正常");
    } catch (Exception $e) {
        // 検索エラー
        http_response_code(400);
        $resultCode = ResultCode::CODE109;
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
    "msg" => $msg,
    "optional" => $optional
);

// レスポンス表示
echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
