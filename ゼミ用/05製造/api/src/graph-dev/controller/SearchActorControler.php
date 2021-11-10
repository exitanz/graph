<?php
require_once dirname(__FILE__) . '/../request/SearchActorRequest.php';
require_once dirname(__FILE__) . '/../service/ActorService.php';
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
    $searchActorRequest = new SearchActorRequest();
    if (!empty($_REQUEST['actor_id'])) $searchActorRequest->setActorId($_REQUEST['actor_id']);
    if (!empty($_REQUEST['actor_name'])) $searchActorRequest->setActorName($_REQUEST['actor_name']);
    if (!empty($_REQUEST['actor_info'])) $searchActorRequest->setActorInfo($_REQUEST['actor_info']);
    if (!empty($_REQUEST['opus_id'])) $searchActorRequest->setOpusId($_REQUEST['opus_id']);
    if (!empty($_REQUEST['time_id'])) $searchActorRequest->setTimeId($_REQUEST['time_id']);
    if (!empty($_REQUEST['group_id'])) $searchActorRequest->setGroupId($_REQUEST['group_id']);
    if (!empty($_REQUEST['user_id'])) $searchActorRequest->setUserId($_REQUEST['user_id']);
    if (!empty($_REQUEST['offset'])) $searchActorRequest->setOffset($_REQUEST['offset']);
    if (!empty($_REQUEST['limit'])) $searchActorRequest->setLimit($_REQUEST['limit']);

    // バリデーションチェック
    if ($searchActorRequest->validation()) {
        // バリデーション違反
        http_response_code(400);
        $resultCode = ResultCode::CODE101;
        $msg = $searchActorRequest->getErrorMsg();
        throw new Exception();
    }

    try {
        // 検索
        $actorService = new ActorService();
        $optional = $actorService->searchActor(
            $searchActorRequest->getActorId(),
            $searchActorRequest->getActorName(),
            $searchActorRequest->getActorInfo(),
            $searchActorRequest->getOpusId(),
            $searchActorRequest->getTimeId(),
            $searchActorRequest->getGroupId(),
            $searchActorRequest->getUserId(),
            $searchActorRequest->getOffset(),
            $searchActorRequest->getLimit()
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
