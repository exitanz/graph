<?php
require_once dirname(__FILE__) . '/../common/Common.php';
require_once dirname(__FILE__) . '/../common/Constant.php';
require_once dirname(__FILE__) . '/../dao/ActorDao.php';
require_once dirname(__FILE__) . '/../dao/OpusDao.php';
require_once dirname(__FILE__) . '/../dao/TimeMstDao.php';
require_once dirname(__FILE__) . '/../dao/GroupMstDao.php';
require_once dirname(__FILE__) . '/../dao/GraphDao.php';
require_once dirname(__FILE__) . '/../dao/RelDao.php';
require_once dirname(__FILE__) . '/../dao/RelMstDao.php';

/**
 * グラフ処理をするクラス
 */
class GraphService {
    /**
     * グラフ検索をします
     */
    public function searchGraph($timeId, $opusId) {
        // 検索処理

        // 存在確認
        if (empty((new OpusDao())->selectByOpusId($opusId))) {
            throw new Exception('作品が存在しません。');
        }
        if (empty((new TimeMstDao())->selectByTimeId($timeId))) {
            throw new Exception('時系列が存在しません。');
        }

        $graphDao = new GraphDao();

        // 登場人物情報リスト取得
        $nodes = $graphDao->selectGraphNodes($timeId, $opusId);

        // 関係情報リスト
        $links = $graphDao->selectGraphLinks($timeId, $opusId);

        return array(
            "nodes" => $nodes,
            "links" => $links
        );
    }
    /**
     * グラフ作成をします
     */
    public function createGraph($graph, $opusId, $userId) {

        // DAO
        $actorDao = new ActorDao();
        $opusDao = new OpusDao();
        $timeMstDao = new TimeMstDao();
        $groupMstDao = new GroupMstDao();
        $relDao = new RelDao();
        $relMstDao = new RelMstDao();

        // 登録ID保管リスト
        $timeIdList = array();
        $groupIdList = array();
        $actorIdList = array();
        $relMstIdList = array();

        $opusTarget = null;
        $opusTargetId = null;

        try {
            if (!empty($opusId)) {
                // 作品取得
                $opusTarget = $opusDao->selectById($opusId, null, $userId);
            }

            // 作品存在チェック
            if (empty($opusTarget)) {
                // 新規作品ID

                // IDの最大値に1加算する
                $opusMax = Common::start_truncate($opusDao->selectMaxId(), strlen(Constant::OPUS_ID_STR)) + 1;

                // ID作成
                $opusTargetId = Constant::OPUS_ID_STR . Common::countup_id($opusMax, Constant::OPUS_ID_DIGIT);

                // 登録処理
                $opusDao->insert($opusTargetId, $graph['nodes'][0]['opus_name'], $userId);
            } else {
                // 既存の作品ID
                $opusTargetId = $opusTarget[0]['opus_id'];
            }

            foreach ($graph['nodes'] as $nodes) {
                if (empty($timeIdList[$nodes['time_id']])) {
                    // 時系列登録

                    // IDの最大値に1加算する
                    $timeMax = Common::start_truncate($timeMstDao->selectMaxId(), strlen(Constant::TIME_ID_STR)) + 1;

                    // ID作成
                    $timeTargetId = Constant::TIME_ID_STR . Common::countup_id($timeMax, Constant::TIME_ID_DIGIT);

                    // 登録処理
                    $timeMstDao->insert($timeTargetId, $nodes['time_name'], $opusTargetId, $userId);

                    $timeIdList[$nodes['time_id']] = $timeTargetId;
                }

                if (empty($groupIdList[$nodes['group_id']])) {
                    // グループ登録

                    // IDの最大値に1加算する
                    $groupMax = Common::start_truncate($groupMstDao->selectMaxId(), strlen(Constant::GROUP_ID_STR)) + 1;

                    // ID作成
                    $groupTargetId = Constant::GROUP_ID_STR . Common::countup_id($groupMax, Constant::GROUP_ID_DIGIT);

                    $groupMstDao->insert($groupTargetId, $nodes['group_name'], $nodes['group_info'], $nodes['_color'], $opusTargetId, $timeIdList[$nodes['time_id']], $userId);

                    $groupIdList[$nodes['group_id']] = $groupTargetId;
                }

                // 登場人物登録

                // IDの最大値に1加算する
                $actorMax = Common::start_truncate($actorDao->selectMaxId(), strlen(Constant::ACTOR_ID_STR)) + 1;

                // ID作成
                $actorTargetId = Constant::ACTOR_ID_STR . Common::countup_id($actorMax, Constant::ACTOR_ID_DIGIT);

                $actorDao->insert($actorTargetId, $nodes['name'], $nodes['actor_info'], $nodes['actor_img'], $opusTargetId, $timeIdList[$nodes['time_id']], $groupIdList[$nodes['group_id']], $userId);

                $actorIdList[$nodes['id']] = $actorTargetId;
            }
            foreach ($graph['links'] as $links) {
                if (empty($timeIdList[$links['time_id']])) {
                    // 時系列登録

                    // IDの最大値に1加算する
                    $timeMax = Common::start_truncate($timeMstDao->selectMaxId(), strlen(Constant::TIME_ID_STR)) + 1;

                    // ID作成
                    $timeTargetId = Constant::TIME_ID_STR . Common::countup_id($timeMax, Constant::TIME_ID_DIGIT);

                    // 登録処理
                    $timeMstDao->insert($timeTargetId, $links['time_name'], $opusTargetId, $userId);

                    $timeIdList[$links['time_id']] = $timeTargetId;
                }

                if (empty($relMstIdList[$links['rel_mst_id']])) {
                    // 関係性登録

                    // IDの最大値に1加算する
                    $relMstIdMax = Common::start_truncate($relMstDao->selectMaxId(), strlen(Constant::REL_MST_ID_STR)) + 1;

                    // ID作成
                    $relMstTargetId = Constant::REL_MST_ID_STR . Common::countup_id($relMstIdMax, Constant::REL_MST_ID_DIGIT);

                    // 登録処理
                    $relMstDao->insert($relMstTargetId, $links['rel_mst_name'], $opusTargetId, $userId);

                    $relMstIdList[$links['rel_mst_id']] = $relMstTargetId;
                }
                // 関係登録

                // IDの最大値に1加算する
                $relIdMax = Common::start_truncate($relDao->selectMaxId(), strlen(Constant::REL_ID_STR)) + 1;

                // ID作成
                $relTargetId = Constant::REL_ID_STR . Common::countup_id($relIdMax, Constant::REL_ID_DIGIT);

                // 登録処理
                $relDao->insert($relTargetId, $relMstTargetId, $links['rel_mst_info'], $actorIdList[$links['sid']], $actorIdList[$links['tid']], $opusTargetId, $timeIdList[$links['time_id']], $userId);
            }
        } catch (Exception $e) {
            // グラフ登録エラー
            throw new Exception('DB操作エラー');
        }

        return array(
            "opus_id" => $opusTargetId
        );
    }
}
