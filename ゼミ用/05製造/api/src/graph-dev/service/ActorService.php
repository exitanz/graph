<?php
require_once dirname(__FILE__) . '/../common/Common.php';
require_once dirname(__FILE__) . '/../common/Constant.php';
require_once dirname(__FILE__) . '/../dao/ActorDao.php';
require_once dirname(__FILE__) . '/../dao/OpusDao.php';

/**
 * 登場人物処理をするクラス
 */
class ActorService {
    /**
     * 登場人物検索をします
     */
    public function searchActor($actorId, $actorName, $actorInfo, $opusId, $timeId, $groupId, $userId, $offset, $limit) {
        // 検索処理
        return (new ActorDao())->select($actorId, $actorName, $actorInfo, $opusId, $timeId, $groupId, $userId, $offset, $limit);
    }

    /**
     * 登場人物全検索をします
     */
    public function searchAllActor() {
        // 検索処理
        return (new ActorDao())->selectAll();
    }

    /**
     * 登場人物登録をします
     */
    public function createActor($actorName, $actorInfo, $actorImg, $opusId, $timeId, $groupId, $userId) {

        if(empty( (new OpusDao())->selectById($opusId, null, $userId))){
            throw new Exception('登場人物が存在しません。');
        }

        // IDの最大値を取得
        $actorDao = new ActorDao();
        $maxId = $actorDao->selectMaxId();

        // IDの最大値に1加算する
        $max = Common::start_truncate($maxId, strlen(Constant::ACTOR_ID_STR)) + 1;

        // ID作成
        $targetId = Constant::ACTOR_ID_STR . Common::countup_id($max, Constant::ACTOR_ID_DIGIT);

        // 登録処理
        $actorDao->insert($targetId, $actorName, $actorInfo, $actorImg, $opusId, $timeId, $groupId, $userId);

        $result = array(
            "actor_id" => $targetId
        );

        return $result;
    }

    /**
     * 登場人物更新をします
     */
    public function editActor($actorId, $actorName, $actorInfo, $actorImg, $opusId, $timeId, $groupId, $userId, $version) {

        // 登場人物情報取得
        $actorDao = new ActorDao();
        $target = $actorDao->selectByIdAndVersion($actorId, $userId, $version);

        // 存在確認
        if (empty($target)) {
            throw new Exception('登場人物が存在しません。');
        }

        // 更新処理
        $actorDao->update($actorId, $actorName, $actorInfo, $actorImg, $opusId, $timeId, $groupId, $userId, $version);
    }

    /**
     * 登場人物情報を削除します
     */
    public function deleteActor($actorId, $userId) {
        // 登場人物情報を取得
        $actorDao = new ActorDao();
        $target = $actorDao->selectById($actorId, $userId);

        if(empty($target)){
            throw new Exception('登場人物が存在しません。');
        }

        // 登場人物情報を削除する
        $actorDao->delete($actorId, $userId);
    }

}
