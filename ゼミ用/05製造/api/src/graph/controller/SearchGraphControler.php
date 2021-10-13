<?php
require_once dirname(__FILE__) . '/../request/SearchGraphRequest.php';
require_once dirname(__FILE__) . '/../service/GraphService.php';
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
    if (strcmp($_SERVER['REQUEST_METHOD'], 'GET') != 0) {
        // メソッドエラー
        http_response_code(404);
        $resultCode = ResultCode::CODE104;
        throw new Exception('メソッドが存在しません。');
    }

    // 認証確認
    if (empty($_REQUEST['user_id']) || empty($_REQUEST['token']) || !(new LoginService())->confirmation($_REQUEST['user_id'], $_REQUEST['token'])) {
        // 認証エラー
        http_response_code(403);
        $resultCode = ResultCode::CODE103;
        throw new Exception('認証されていません');
    }

    // リクエストの値を格納
    $searchGraphRequest = new SearchGraphRequest();
    if (!empty($_REQUEST['time_id'])) $searchGraphRequest->setTimeId($_REQUEST['time_id']);
    if (!empty($_REQUEST['opus_id'])) $searchGraphRequest->setOpusId($_REQUEST['opus_id']);

    // バリデーションチェック
    if ($searchGraphRequest->validation()) {
        // バリデーション違反
        http_response_code(400);
        $resultCode = ResultCode::CODE101;
        $msg = $searchGraphRequest->getErrorMsg();
        throw new Exception();
    }

    try {
        // 検索
        $optional = (new GraphService())->searchGraph(
            $searchGraphRequest->getTimeId(),
            $searchGraphRequest->getOpusId()
        );
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
