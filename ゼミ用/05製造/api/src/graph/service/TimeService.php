<?php
require_once dirname(__FILE__) . '/../common/Common.php';
require_once dirname(__FILE__) . '/../common/Constant.php';
require_once dirname(__FILE__) . '/../dao/TimeMstDao.php';
require_once dirname(__FILE__) . '/../dao/OpusDao.php';

/**
 * 時系列処理をするクラス
 */
class TimeService {
    /**
     * 時系列検索をします
     */
    public function searchTime($timeId, $timeName, $opusId, $userId, $offset, $limit) {
        // 検索処理
        return (new TimeMstDao())->select($timeId, $timeName, $opusId, $userId, $offset, $limit);
    }

    /**
     * 時系列全検索をします
     */
    public function searchAllTime() {
        // 検索処理
        return (new TimeMstDao())->selectAll();
    }

    /**
     * 時系列登録をします
     */
    public function createTime($timeName, $opusId, $userId) {

        if(empty( (new OpusDao())->selectById($opusId, null, $userId))){
            throw new Exception('作品が存在しません。');
        }

        // IDの最大値を取得
        $timeMstDao = new TimeMstDao();
        $maxId = $timeMstDao->selectMaxId();

        // IDの最大値に1加算する
        $max = Common::start_truncate($maxId, strlen(Constant::TIME_ID_STR)) + 1;

        // ID作成
        $targetId = Constant::TIME_ID_STR . Common::countup_id($max, Constant::TIME_ID_DIGIT);

        // 登録処理
        $timeMstDao->insert($targetId, $timeName, $opusId, $userId);

        $result = array(
            "time_id" => $targetId
        );

        return $result;
    }

    /**
     * 時系列更新をします
     */
    public function editTime($timeId, $timeName, $userId, $version) {

        // 時系列情報取得
        $timeMstDao = new TimeMstDao();
        $target = $timeMstDao->selectByIdAndVersion($timeId, null, $userId, $version);

        // 存在確認
        if (empty($target)) {
            throw new Exception('時系列が存在しません。');
        }

        // 更新処理
        $timeMstDao->update($timeId, $timeName, $userId, $version);
    }

    /**
     * 時系列情報を削除します
     */
    public function deleteTime($timeId, $userId) {
        // 時系列情報を取得
        $timeMstDao = new TimeMstDao();
        $target = $timeMstDao->selectById($timeId, null, $userId);

        if(empty($target)){
            throw new Exception('時系列が存在しません。');
        }

        // 時系列情報を削除する
        $timeMstDao->delete($timeId, $userId);
    }
}
