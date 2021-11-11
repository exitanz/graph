<?php
require_once dirname(__FILE__) . '/../request/EditRelMstRequest.php';
require_once dirname(__FILE__) . '/../service/RelMstService.php';
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
    $editRelMstRequest = new EditRelMstRequest();
    if (!empty($REQUEST['rel_mst_id'])) $editRelMstRequest->setRelMstId($REQUEST['rel_mst_id']);
    if (!empty($REQUEST['rel_mst_name'])) $editRelMstRequest->setRelMstName($REQUEST['rel_mst_name']);
    if (!empty($REQUEST['user_id'])) $editRelMstRequest->setUserId($REQUEST['user_id']);
    if (!empty($REQUEST['version'])) $editRelMstRequest->setVersion($REQUEST['version']); 

    // バリデーションチェック
    if ($editRelMstRequest->validation()) {
        // バリデーション違反
        http_response_code(400);
        $resultCode = ResultCode::CODE101;
        $msg = $editRelMstRequest->getErrorMsg();
        throw new Exception();
    }

    try {
        // 作品更新
        (new RelMstService())->editRelMst(
            $editRelMstRequest->getRelMstId(),
            $editRelMstRequest->getRelMstName(),
            $editRelMstRequest->getUserId(),
            $editRelMstRequest->getVersion()
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
