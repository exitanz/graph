<?php
require_once dirname(__FILE__).'/../common/Common.php';
require_once dirname(__FILE__).'/../common/Constant.php';
require_once dirname(__FILE__).'/../dao/CorUserDao.php';
require_once dirname(__FILE__).'/../dto/CorUser.php';

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

        // パスワードの暗号化
        $passwordSha256 = crypt($password, '$5$rounds=5000$usesomesillystringforsalt$');

        // パスワードの比較
        if($passwordSha256 == $corUser->getPassword()){
            // ユーザIDとパスワードをセッションに格納
            $_SESSION['user_id'] = $corUser->getUserId();
            $_SESSION['user_name'] = $corUser->getUserName();
            $_SESSION['password'] = $corUser->getPassword();

            return true;
        }

        return false;

    }

    /**
     * ログイン状況の確認を行います
     */
    public function confirmation($userId, $password) {
        // ユーザIDをキーにユーザ情報取得
        $corUserDao = new CorUserDao();
        $corUser = $corUserDao->selectByUserId($userId);

        // パスワードの比較
        if($password == $corUser->getPassword()){
            return true;
        }
        return false;
    }

}
