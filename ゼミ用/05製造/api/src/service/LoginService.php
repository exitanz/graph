<?php
require_once dirname(__FILE__) . '/../common/Common.php';
require_once dirname(__FILE__) . '/../common/Constant.php';
require_once dirname(__FILE__) . '/../dao/CorUserDao.php';
require_once dirname(__FILE__) . '/../dto/CorUser.php';

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

        if(empty($corUser)){
            throw new Exception('ユーザIDまたはパスワードが一致しません。');
        }

        // パスワードの暗号化
        $passwordSha256 = crypt($password, '$5$rounds=5000$usesomesillystringforsalt$');

        // パスワードの比較
        if (strcmp($passwordSha256, $corUser->getPassword()) != 0) {
            throw new Exception('ユーザIDまたはパスワードが一致しません。');
        }

        $optional = array(
            "user_id" => $corUser->getUserId(),
            "user_name" => $corUser->getUserName(),
            "password" => $corUser->getPassword(),
            "version" => $corUser->getVersion()
        );

        return $optional;
    }

    /**
     * ログイン状況の確認を行います
     */
    public function confirmation($userId, $password) {
        // ユーザIDをキーにユーザ情報取得
        $corUserDao = new CorUserDao();
        $corUser = $corUserDao->selectByUserId($userId);

        if(empty($corUser)){
            throw new Exception('ユーザIDまたはパスワードが一致しません。');
        }

        // パスワードの暗号化
        $passwordSha256 = crypt($password, '$5$rounds=5000$usesomesillystringforsalt$');

        // パスワードの比較
        if (strcmp($passwordSha256, $corUser->getPassword()) == 0) {
            return true;
        }
        return false;
    }
}
