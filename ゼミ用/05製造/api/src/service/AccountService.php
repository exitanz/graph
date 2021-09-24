<?php
require_once dirname(__FILE__).'/../common/Common.php';
require_once dirname(__FILE__).'/../common/Constant.php';
require_once dirname(__FILE__).'/../dao/CorUserDao.php';

/**
 * 新規登録処理をするクラス
 */
class AccountService {

    /**
     * 新規登録をします
     */
    public function createAccount($userName, $password) {
        // ユーザIDの最大値を取得
        $corUserDao = new CorUserDao();
        $maxId = $corUserDao->selectMaxId();

        // ユーザIDの最大値に1加算する
        $max = Common::start_truncate($maxId, strlen(Constant::USER_ID_STR)) + 1;

        // ユーザID作成
        $userId = Constant::USER_ID_STR.Common::countup_id($max, Constant::USER_ID_DIGIT);

        // パスワードの暗号化（sha256）
        $passwordSha256 = hash("sha256", $password);

        // ユーザID, ユーザ名, パスワードを登録する
        $corUserDao->insert($userId, $userName, $passwordSha256);

        return 'アカウント登録が完了しました（ユーザID：'.$userId.'）';
    }
}
