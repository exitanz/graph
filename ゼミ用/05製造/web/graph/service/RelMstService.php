<?php
require_once dirname(__FILE__) . '/../common/Common.php';
require_once dirname(__FILE__) . '/../common/Constant.php';
require_once dirname(__FILE__) . '/../dao/RelMstDao.php';
require_once dirname(__FILE__) . '/../dao/OpusDao.php';

/**
 * 関係性処理をするクラス
 */
class RelMstService {
    /**
     * 関係性検索をします
     */
    public function searchRelMst($relMstId, $relMstName, $opusId, $userId, $offset, $limit) {
        // 検索処理
        return (new RelMstDao())->select($relMstId, $relMstName, $opusId, $userId, $offset, $limit);
    }

    /**
     * 関係性全検索をします
     */
    public function searchAllRelMst() {
        // 検索処理
        return (new RelMstDao())->selectAll();
    }

    /**
     * 関係性登録をします
     */
    public function createRelMst($relMstName, $opusId, $userId) {

        if(empty( (new OpusDao())->selectById($opusId, null, $userId))){
            throw new Exception('作品が存在しません。');
        }

        // IDの最大値を取得
        $RelMstDao = new RelMstDao();
        $maxId = $RelMstDao->selectMaxId();

        // IDの最大値に1加算する
        $max = Common::start_truncate($maxId, strlen(Constant::REL_MST_ID_STR)) + 1;

        // ID作成
        $targetId = Constant::REL_MST_ID_STR . Common::countup_id($max, Constant::REL_MST_ID_DIGIT);

        // 登録処理
        $RelMstDao->insert($targetId, $relMstName, $opusId, $userId);

        $result = array(
            "relMst_id" => $targetId
        );

        return $result;
    }

    /**
     * 関係性更新をします
     */
    public function editRelMst($relMstId, $relMstName, $userId, $version) {

        // 関係性情報取得
        $RelMstDao = new RelMstDao();
        $target = $RelMstDao->selectByIdAndVersion($relMstId, null, $userId, $version);

        // 存在確認
        if (empty($target)) {
            throw new Exception('関係性が存在しません。');
        }

        // 更新処理
        $RelMstDao->update($relMstId, $relMstName, $userId, $version);
    }

    /**
     * 関係性情報を削除します
     */
    public function deleteRelMst($relMstId, $userId) {
        // 関係性情報を取得
        $RelMstDao = new RelMstDao();
        $corUser = $RelMstDao->selectById($relMstId, null, $userId);

        if(empty($corUser)){
            throw new Exception('関係性が存在しません。');
        }

        // 関係性情報を削除する
        $RelMstDao->delete($relMstId, $userId);
    }
}
