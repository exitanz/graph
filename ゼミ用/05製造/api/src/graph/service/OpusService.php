<?php
require_once dirname(__FILE__) . '/../common/Common.php';
require_once dirname(__FILE__) . '/../common/Constant.php';
require_once dirname(__FILE__) . '/../dao/OpusDao.php';

/**
 * 作品処理をするクラス
 */
class OpusService {
    /**
     * 作品検索をします
     */
    public function searchOpus($opusId, $opusName, $userId, $offset, $limit) {
        // 検索処理
        return (new OpusDao())->select($opusId, $opusName, $userId, $offset, $limit);
    }

    /**
     * 作品全検索をします
     */
    public function searchAllOpus() {
        // 検索処理
        return (new OpusDao())->selectAll();
    }

    /**
     * 作品登録をします
     */
    public function createOpus($opusName, $user_id) {
        // IDの最大値を取得
        $opusDao = new OpusDao();
        $maxId = $opusDao->selectMaxId();

        // IDの最大値に1加算する
        $max = Common::start_truncate($maxId, strlen(Constant::OPUS_ID_STR)) + 1;

        // ID作成
        $targetId = Constant::OPUS_ID_STR . Common::countup_id($max, Constant::OPUS_ID_DIGIT);

        // 登録処理
        $opusDao->insert($targetId, $opusName, $user_id);

        $result = array(
            "opus_id" => $targetId
        );

        return $result;
    }

    /**
     * 作品更新をします
     */
    public function editOpus($opusId, $opusName, $userId, $version) {
        // 作品情報取得
        $opusDao = new OpusDao();
        $target = $opusDao->selectByIdAndVersion($opusId, null, $userId, $version);

        // 存在確認
        if (empty($target)) {
            throw new Exception('作品が存在しません。');
        }

        // 更新処理
        $opusDao->update($opusId, $opusName, $userId, $version);
    }
}
