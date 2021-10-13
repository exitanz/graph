<?php
require_once dirname(__FILE__) . '/../common/Common.php';
require_once dirname(__FILE__) . '/../common/Constant.php';
require_once dirname(__FILE__) . '/../dao/CommonMstDao.php';
require_once dirname(__FILE__) . '/../dao/OpusDao.php';

/**
 * 汎用マスタ処理をするクラス
 */
class CommonMstService {
    /**
     * 汎用マスタ検索をします
     */
    public function searchCommonMst($key) {
        // 検索処理
        return (new CommonMstDao())->select($key);
    }
}
