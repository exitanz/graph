<?php
require_once dirname(__FILE__) . '/../request/CreateActorRequest.php';
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
    $createActorRequest = new CreateActorRequest();
    if (!empty($REQUEST['actor_name'])) $createActorRequest->setActorName($REQUEST['actor_name']);
    if (!empty($REQUEST['actor_info'])) $createActorRequest->setActorInfo($REQUEST['actor_info']);
    if (!empty($REQUEST['actor_img'])) $createActorRequest->setActorImg($REQUEST['actor_img']);
    if (!empty($REQUEST['opus_id'])) $createActorRequest->setOpusId($REQUEST['opus_id']);
    if (!empty($REQUEST['time_id'])) $createActorRequest->setTimeId($REQUEST['time_id']);
    if (!empty($REQUEST['group_id'])) $createActorRequest->setGroupId($REQUEST['group_id']);
    if (!empty($REQUEST['user_id'])) $createActorRequest->setUserId($REQUEST['user_id']);

    // バリデーションチェック
    if ($createActorRequest->validation()) {
        // バリデーション違反
        http_response_code(400);
        $resultCode = ResultCode::CODE101;
        $msg = $createActorRequest->getErrorMsg();
        throw new Exception();
    }

    try {
        // 登場人物登録
        $optional = (new ActorService())->createActor(
            $createActorRequest->getActorName(),
            $createActorRequest->getActorInfo(),
            $createActorRequest->getActorImg(),
            $createActorRequest->getOpusId(),
            $createActorRequest->getTimeId(),
            $createActorRequest->getGroupId(),
            $createActorRequest->getUserId()
        );
        array_push($msg, "正常");
    } catch (Exception $e) {
        // 登場人物登録エラー
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
