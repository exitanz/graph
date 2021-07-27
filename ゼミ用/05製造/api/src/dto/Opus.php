<?php

/**
 * 時系列マスタを格納するクラス
 */
class TimeMst
{

    private $opusId;
    private $opusName;
    private $userId;
    private $version;

    public function getOpusId()
    {
        return $this->opusId;
    }

    public function setOpusId($opusId)
    {
        $this->opusId = $opusId;
    }

    public function getOpusName()
    {
        return $this->opusName;
    }

    public function setOpusName($opusName)
    {
        $this->opusName = $opusName;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function setVersion($version)
    {
        $this->version = $version;
    }
}
