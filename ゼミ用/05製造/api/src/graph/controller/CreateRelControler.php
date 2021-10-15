<?php
require_once dirname(__FILE__) . '/../request/CreateRelRequest.php';
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
    $createRelRequest = new CreateRelRequest();
    if (!empty($REQUEST['rel_mst_id'])) $createRelRequest->setRelMstId($REQUEST['rel_mst_id']);
    if (!empty($REQUEST['rel_mst_info'])) $createRelRequest->setRelMstInfo($REQUEST['rel_mst_info']);
    if (!empty($REQUEST['actor_id'])) $createRelRequest->setActerId($REQUEST['actor_id']);
    if (!empty($REQUEST['target_id'])) $createRelRequest->setTargetId($REQUEST['target_id']);
    if (!empty($REQUEST['opus_id'])) $createRelRequest->setOpusId($REQUEST['opus_id']);
    if (!empty($REQUEST['time_id'])) $createRelRequest->setTimeId($REQUEST['time_id']);
    if (!empty($REQUEST['user_id'])) $createRelRequest->setUserId($REQUEST['user_id']);

    // バリデーションチェック
    if ($createRelRequest->validation()) {
        // バリデーション違反
        http_response_code(400);
        $resultCode = ResultCode::CODE101;
        $msg = $createRelRequest->getErrorMsg();
        throw new Exception();
    }

    try {
        // 関係登録
        $optional = (new RelService())->createRel(
            $createRelRequest->getRelMstId(),
            $createRelRequest->getRelMstInfo(),
            $createRelRequest->getActerId(),
            $createRelRequest->getTargetId(),
            $createRelRequest->getOpusId(),
            $createRelRequest->getTimeId(),
            $createRelRequest->getUserId(),
        );
        array_push($msg, "正常");
    } catch (Exception $e) {
        // 関係登録エラー
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
