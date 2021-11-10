<?php
require_once dirname(__FILE__) . '/../request/SearchRelRequest.php';
require_once dirname(__FILE__) . '/../service/RelService.php';
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
    if (empty($_REQUEST['user_id']) || empty($_REQUEST['token']) || !(new LoginService())->confirmation($_REQUEST['user_id'], $_REQUEST['token'])) {
        // 認証エラー
        http_response_code(403);
        $resultCode = ResultCode::CODE103;
        throw new Exception('認証されていません');
    }

    // リクエストの値を格納
    $searchRelRequest = new SearchRelRequest();
    if (!empty($_REQUEST['rel_id'])) $searchRelRequest->setRelId($_REQUEST['rel_id']);
    if (!empty($_REQUEST['rel_mst_id'])) $searchRelRequest->setRelMstId($_REQUEST['rel_mst_id']);
    if (!empty($_REQUEST['rel_mst_info'])) $searchRelRequest->setRelMstInfo($_REQUEST['rel_mst_info']);
    if (!empty($_REQUEST['actor_id'])) $searchRelRequest->setActorId($_REQUEST['actor_id']);
    if (!empty($_REQUEST['target_id'])) $searchRelRequest->setTargetId($_REQUEST['target_id']);
    if (!empty($_REQUEST['opus_id'])) $searchRelRequest->setOpusId($_REQUEST['opus_id']);
    if (!empty($_REQUEST['time_id'])) $searchRelRequest->setTimeId($_REQUEST['time_id']);
    if (!empty($_REQUEST['user_id'])) $searchRelRequest->setUserId($_REQUEST['user_id']);
    if (!empty($_REQUEST['offset'])) $searchRelRequest->setOffset($_REQUEST['offset']);
    if (!empty($_REQUEST['limit'])) $searchRelRequest->setLimit($_REQUEST['limit']);

    // バリデーションチェック
    if ($searchRelRequest->validation()) {
        // バリデーション違反
        http_response_code(400);
        $resultCode = ResultCode::CODE101;
        $msg = $searchRelRequest->getErrorMsg();
        throw new Exception();
    }

    try {
        // 検索
        $relService = new RelService();
        $optional = $relService->searchRel(
            $searchRelRequest->getRelId(),
            $searchRelRequest->getRelMstId(),
            $searchRelRequest->getRelMstInfo(),
            $searchRelRequest->getActorId(),
            $searchRelRequest->getTargetId(),
            $searchRelRequest->getOpusId(),
            $searchRelRequest->getTimeId(),
            $searchRelRequest->getUserId(),
            $searchRelRequest->getOffset(),
            $searchRelRequest->getLimit()
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
