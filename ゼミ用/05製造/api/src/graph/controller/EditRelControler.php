<?php
require_once dirname(__FILE__) . '/../request/EditRelRequest.php';
require_once dirname(__FILE__) . '/../service/RelService.php';
require_once dirname(__FILE__) . '/../service/LoginService.php';
require_once dirname(__FILE__) . '/../common/ResultCode.php';
// ヘッダーを指定
header("Content-Type: application/json; charset=utf-8");

// 変数
$resultCode = ResultCode::CODE000;
$msg = array();

try {
    if (strcmp((string)$_SERVER['REQUEST_METHOD'], 'PUT') != 0) {
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
    $editRelRequest = new EditRelRequest();
    if (!empty($REQUEST['rel_id'])) $editRelRequest->setRelId($REQUEST['rel_id']);
    if (!empty($REQUEST['rel_mst_id'])) $editRelRequest->setRelMstId($REQUEST['rel_mst_id']);
    if (!empty($REQUEST['rel_mst_info'])) $editRelRequest->setRelMstInfo($REQUEST['rel_mst_info']);
    if (!empty($REQUEST['actor_id'])) $editRelRequest->setActorId($REQUEST['actor_id']);
    if (!empty($REQUEST['target_id'])) $editRelRequest->setTargetId($REQUEST['target_id']);
    if (!empty($REQUEST['opus_id'])) $editRelRequest->setOpusId($REQUEST['opus_id']);
    if (!empty($REQUEST['time_id'])) $editRelRequest->setTimeId($REQUEST['time_id']);
    if (!empty($REQUEST['user_id'])) $editRelRequest->setUserId($REQUEST['user_id']);
    if (!empty($REQUEST['version'])) $editRelRequest->setVersion($REQUEST['version']);

    // バリデーションチェック
    if ($editRelRequest->validation()) {
        // バリデーション違反
        http_response_code(400);
        $resultCode = ResultCode::CODE101;
        $msg = $editRelRequest->getErrorMsg();
        throw new Exception();
    }

    try {
        // 作品更新
        (new RelService())->editRel(
            $editRelRequest->getRelId(),
            $editRelRequest->getRelMstId(),
            $editRelRequest->getRelMstInfo(),
            $editRelRequest->getActorId(),
            $editRelRequest->getTargetId(),
            $editRelRequest->getOpusId(),
            $editRelRequest->getTimeId(),
            $editRelRequest->getUserId(),
            $editRelRequest->getVersion()
        );
        array_push($msg, "正常");
    } catch (Exception $e) {
        // 作品登録エラー
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
    "msg" => $msg
);

// レスポンス表示
echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
