<?php
require_once dirname(__FILE__) . '/../common/Common.php';
require_once dirname(__FILE__) . '/../common/Constant.php';
require_once dirname(__FILE__) . '/../dao/CorUserDao.php';

/**
 * 新規登録処理をするクラス
 */
class AccountService
{

    /**
     * アカウント全検索をします
     */
    public function searchAllAccount()
    {
        // 検索処理
        return (new CorUserDao())->selectAll();
    }

    /**
     * 新規登録をします
     */
    public function createAccount($userName, $password)
    {
        // ユーザIDの最大値を取得
        $corUserDao = new CorUserDao();
        $maxId = $corUserDao->selectMaxId();

        // ユーザIDの最大値に1加算する
        $max = Common::start_truncate($maxId, strlen(Constant::USER_ID_STR)) + 1;

        // ユーザID作成
        $userId = Constant::USER_ID_STR . Common::countup_id($max, Constant::USER_ID_DIGIT);

        // パスワードの暗号化（sha256）
        $passwordSha256 = password_hash($password, PASSWORD_DEFAULT);

        // ユーザID, ユーザ名, パスワードを登録する
        $corUserDao->insert($userId, $userName, $passwordSha256);

        // フォルダ存在確認
        if (!file_exists('../../user/' . $userId)) {
            // フォルダ作成処理
            mkdir('../../user/' . $userId, 0777);
        }

        return $userId;
    }

    /**
     * アカウント更新をします
     * 
     */
    public function editAccount($userId, $userName, $password, $version)
    {

        // アカウント情報取得
        $corUserDao = new CorUserDao();
        $target = $corUserDao->selectByIdAndVersion($userId, $version);

        // 存在確認
        if (empty($target)) {
            throw new Exception('アカウントが存在しません。');
        }

        // パスワードの暗号化（sha256）
        $passwordSha256 = password_hash($password, PASSWORD_DEFAULT);

        // 更新処理
        $corUserDao->update($userId, $userName, $passwordSha256, $version);
    }

    /**
     * ユーザ情報を削除します
     */
    public function deleteAccount($userId)
    {
        // ユーザ情報を取得
        $corUserDao = new CorUserDao();
        $corUser = $corUserDao->selectByUserId($userId);

        if (empty($corUser)) {
            throw new Exception('ユーザが存在しません。');
        }

        // ユーザ情報を削除する
        $corUserDao->delete($userId);
    }
}
