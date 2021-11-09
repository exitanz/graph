<?php
require_once dirname(__FILE__) . '/../service/LoginService.php';
require_once dirname(__FILE__) . '/../common/ResultCode.php';
require_once dirname(__FILE__) . '/../common/Common.php';
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

    // バリデーションチェック
    if (empty($REQUEST['actor_img'])) {
        // バリデーション違反
        http_response_code(400);
        $resultCode = ResultCode::CODE101;
        $msg = array('画像が存在しません');
        throw new Exception();
    }

    try {
        // base64画像をデコード
        $img = Common::decode($REQUEST['actor_img']);
        // 拡張子取得
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimetype = $finfo->buffer($img);
        if (!Common::isImgMimetype($mimetype)) {
            // 拡張子が画像ではない
            http_response_code(400);
            $resultCode = ResultCode::CODE101;
            $msg = array('拡張子が画像ファイルではありません');
            throw new Exception();
        }
        // base64画像登録
        $imgPath = '/user/' . $REQUEST['user_id'] . '/' . time() . '.' . Common::getImgMimetype($mimetype);
        file_put_contents('../..' . $imgPath, $img);

        array_push($msg, "正常");
        array_push($optional, array("actor_img" => $imgPath));
    } catch (Exception $e) {
        // 画像登録処理エラー
        http_response_code(400);
        $resultCode = ResultCode::CODE101;
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
