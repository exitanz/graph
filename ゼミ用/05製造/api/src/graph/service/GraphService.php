<?php
require_once dirname(__FILE__) . '/../common/Common.php';
require_once dirname(__FILE__) . '/../common/Constant.php';
require_once dirname(__FILE__) . '/../dao/OpusDao.php';
require_once dirname(__FILE__) . '/../dao/TimeMstDao.php';
require_once dirname(__FILE__) . '/../dao/GraphDao.php';
require_once dirname(__FILE__) . '/../dao/OpusDao.php';

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
}
