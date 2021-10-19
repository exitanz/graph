<?php
require_once dirname(__FILE__) . '/../request/CreateGraphRequest.php';
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
    if (strcmp($_SERVER['REQUEST_METHOD'], 'POST') != 0) {
        // メソッドエラー
        http_response_code(404);
        $resultCode = ResultCode::CODE104;
        throw new Exception('メソッドが存在しません。');
    }

    // リクエスト取得
    $REQUEST = json_decode(file_get_contents("php://input"), true);

    // 認証確認
    if (empty($REQUEST['user_id']) || empty($REQUEST['token']) || !(new LoginService())->confirmation($REQUEST['user_id'], $REQUEST['token'])) {
        // 認証エラー
        http_response_code(403);
        $resultCode = ResultCode::CODE103;
        throw new Exception('認証されていません');
    }

    // リクエストの値を格納
    $createGraphRequest = new CreateGraphRequest();
    if (!empty($REQUEST['graph'])) $createGraphRequest->setGraph($REQUEST['graph']);
    if (!empty($REQUEST['opus_id'])) $createGraphRequest->setOpusId($REQUEST['opus_id']);
    if (!empty($REQUEST['user_id'])) $createGraphRequest->setUserId($REQUEST['user_id']);

    // バリデーションチェック
    if ($createGraphRequest->validation()) {
        // バリデーション違反
        http_response_code(400);
        $resultCode = ResultCode::CODE101;
        $msg = $createGraphRequest->getErrorMsg();
        throw new Exception();
    }

    try {
        // グラフ登録
        $optional = (new GraphService())->createGraph($createGraphRequest->getGraph(), $createGraphRequest->getOpusId(), $createGraphRequest->getUserId());
        array_push($msg, "正常");
    } catch (Exception $e) {
        // グラフ登録エラー
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
