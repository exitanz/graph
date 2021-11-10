<?php
require_once dirname(__FILE__) . '/../request/SearchOpusRequest.php';
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
    $searchOpusRequest = new SearchOpusRequest();
    if (!empty($_REQUEST['opus_id'])) $searchOpusRequest->setOpusId($_REQUEST['opus_id']);
    if (!empty($_REQUEST['opus_name'])) $searchOpusRequest->setOpusName($_REQUEST['opus_name']);
    if (!empty($_REQUEST['user_id'])) $searchOpusRequest->setUserId($_REQUEST['user_id']);
    if (!empty($_REQUEST['offset'])) $searchOpusRequest->setOffset($_REQUEST['offset']);
    if (!empty($_REQUEST['limit'])) $searchOpusRequest->setLimit($_REQUEST['limit']);

    // バリデーションチェック
    if ($searchOpusRequest->validation()) {
        // バリデーション違反
        http_response_code(400);
        $resultCode = ResultCode::CODE101;
        $msg = $searchOpusRequest->getErrorMsg();
        throw new Exception();
    }

    try {
        // 検索
        $opusService = new OpusService();
        $optional = $opusService->searchOpus(
            $searchOpusRequest->getOpusId(), 
            $searchOpusRequest->getOpusName(), 
            $searchOpusRequest->getUserId(),
            $searchOpusRequest->getOffset(),
            $searchOpusRequest->getLimit()
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
