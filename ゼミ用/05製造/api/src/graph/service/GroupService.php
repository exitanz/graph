<?php
require_once dirname(__FILE__) . '/../common/Common.php';
require_once dirname(__FILE__) . '/../common/Constant.php';
require_once dirname(__FILE__) . '/../dao/GroupMstDao.php';
require_once dirname(__FILE__) . '/../dao/OpusDao.php';

/**
 * グループ処理をするクラス
 */
class GroupService {
    /**
     * グループ検索をします
     */
    public function searchTime($groupName, $groupInfo, $opusId, $timeId, $userId, $offset, $limit) {
        // 検索処理
        return (new GroupMstDao())->select($groupName, $groupInfo, $opusId, $timeId, $userId, $offset, $limit);
    }

    /**
     * グループ全検索をします
     */
    public function searchAllTime() {
        // 検索処理
        return (new GroupMstDao())->selectAll();
    }

    /**
     * グループ登録をします
     */
    public function createGroup($groupName, $groupInfo, $opusId, $timeId, $userId) {

        if(empty( (new OpusDao())->selectById($opusId, null, $userId))){
            throw new Exception('作品が存在しません。');
        }

        // IDの最大値を取得
        $groupMstDao = new GroupMstDao();
        $maxId = $groupMstDao->selectMaxId();

        // IDの最大値に1加算する
        $max = Common::start_truncate($maxId, strlen(Constant::GROUP_ID_STR)) + 1;

        // ID作成
        $targetId = Constant::GROUP_ID_STR . Common::countup_id($max, Constant::GROUP_ID_DIGIT);

        // 登録処理
        $groupMstDao->insert($targetId, $groupName, $groupInfo, $opusId, $timeId, $userId);

        $result = array(
            "group_id" => $targetId
        );

        return $result;
    }

    /**
     * グループ更新をします
     */
    public function editTime($timeId, $timeName, $userId, $version) {

        // グループ情報取得
        $groupMstDao = new GroupMstDao();
        $target = $groupMstDao->selectByIdAndVersion($timeId, null, $userId, $version);

        // 存在確認
        if (empty($target)) {
            throw new Exception('グループが存在しません。');
        }

        // 更新処理
        $groupMstDao->update($timeId, $timeName, $userId, $version);
    }

    /**
     * グループ情報を削除します
     */
    public function deleteTime($timeId, $userId) {
        // グループ情報を取得
        $groupMstDao = new GroupMstDao();
        $corUser = $groupMstDao->selectById($timeId, null, $userId);

        if(empty($corUser)){
            throw new Exception('グループが存在しません。');
        }

        // グループ情報を削除する
        $groupMstDao->delete($timeId, $userId);
    }
}
