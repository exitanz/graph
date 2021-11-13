<?php
require_once dirname(__FILE__) . '/../common/Common.php';
require_once dirname(__FILE__) . '/../common/Constant.php';
require_once dirname(__FILE__) . '/../dao/CorUserDao.php';

// セッション開始
if (!isset($_SESSION)) {
    session_start();
}

/**
 * ログイン処理をするクラス
 */
class LoginService {

    /**
     * ログイン処理をします
     */
    public function login($userId, $password) {
        // ユーザIDをキーにユーザ情報取得
        $corUserDao = new CorUserDao();
        $corUser = $corUserDao->selectByUserId($userId);

        if (empty($corUser)) {
            throw new Exception('ユーザIDまたはパスワードが一致しません。');
        }

        // パスワードの比較
        if (!password_verify($password, $corUser['password'])) {
            throw new Exception('ユーザIDまたはパスワードが一致しません。');
        }

        // トークン生成
        $token = hash("sha256", $corUser['user_id'] . date('Y-m-d H:i:s'));

        // クッキー削除
        setcookie("graphtoken[" . $corUser['user_id'] . "]", "", time() - 60);

        // トークンをクッキーに保存
        setcookie("graphtoken[" . $corUser['user_id'] . "]", $token, time() + 86400, "/");

        // ユーザIDとトークンを返却
        $result = array(
            "user_id" => $corUser['user_id'],
            "token" => $token
        );

        return $result;
    }

    /**
     * ログイン状況の確認を行います
     */
    public function confirmation($userId, $token) {

        $tokenFlg = false;

        // トークンの存在チェック
        if (empty($token)) {
            throw new Exception('認証確認ができません。');
        }

        if (isset($_COOKIE["graphtoken"][$userId])) {
            if (strcmp((string)$_COOKIE["graphtoken"][$userId], (string)$token) == 0) {
                // 認証されている
                $tokenFlg = true;
            }
        }
        return $tokenFlg;
    }
}
