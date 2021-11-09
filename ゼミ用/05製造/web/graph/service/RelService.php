<?php
require_once dirname(__FILE__) . '/../common/Common.php';
require_once dirname(__FILE__) . '/../common/Constant.php';
require_once dirname(__FILE__) . '/../dao/RelDao.php';
require_once dirname(__FILE__) . '/../dao/OpusDao.php';
require_once dirname(__FILE__) . '/../dao/RelMstDao.php';

/**
 * 関係処理をするクラス
 */
class RelService {
    /**
     * 関係検索をします
     */
    public function searchRel($relId, $relName, $relMstInfo, $actorId, $targetId, $opusId, $timeId, $userId, $offset, $limit) {
        // 検索処理
        return (new RelDao())->select($relId, $relName, $relMstInfo, $actorId, $targetId, $opusId, $timeId, $userId, $offset, $limit);
    }

    /**
     * 関係全検索をします
     */
    public function searchAllRel() {
        // 検索処理
        return (new RelDao())->selectAll();
    }

    /**
     * 関係登録をします
     */
    public function createRel($relMstId, $relMstInfo, $actorId, $targetId, $opusId, $timeId, $userId) {

        if(empty( (new OpusDao())->selectById($opusId, null, $userId))){
            throw new Exception('作品が存在しません。');
        }

        if(empty( (new RelMstDao())->selectById($relMstId, null, $userId))){
            throw new Exception('関係性が存在しません。');
        }

        // IDの最大値を取得
        $relDao = new RelDao();
        $maxId = $relDao->selectMaxId();

        // IDの最大値に1加算する
        $max = Common::start_truncate($maxId, strlen(Constant::REL_ID_STR)) + 1;

        // ID作成
        $relId = Constant::REL_ID_STR . Common::countup_id($max, Constant::REL_ID_DIGIT);

        // 登録処理
        $relDao->insert($relId, $relMstId, $relMstInfo, $actorId, $targetId, $opusId, $timeId, $userId);

        $result = array(
            "rel_id" => $relId
        );

        return $result;
    }

    /**
     * 関係更新をします
     */
    public function editRel($relId, $relMstId, $relMstInfo, $actorId, $targetId, $opusId, $timeId, $userId, $version) {

        // 関係情報取得
        $relDao = new RelDao();
        $target = $relDao->selectByIdAndVersion($relId, $userId, $version);

        // 存在確認
        if (empty($target)) {
            throw new Exception('関係が存在しません。');
        }

        // 更新処理
        $relDao->update($relId, $relMstId, $relMstInfo, $actorId, $targetId, $opusId, $timeId, $userId, $version);
    }

    /**
     * 関係情報を削除します
     */
    public function deleteRel($relId, $userId) {
        // 関係情報を取得
        $relDao = new RelDao();
        $target = $relDao->selectById($relId, $userId);

        if(empty($target)){
            throw new Exception('関係が存在しません。');
        }

        // 関係情報を削除する
        $relDao->delete($relId, $userId);
    }
}
