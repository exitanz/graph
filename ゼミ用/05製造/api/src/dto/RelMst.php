<?php

/**
 * 関係マスタを格納するクラス
 */
class RelMst
{

  private $relMstId;
  private $relMstName;
  private $opusId;
  private $userId;
  private $version;

  public function getRelMstId()
  {
    return $this->relMstId;
  }

  public function setRelMstId($relMstId)
  {
    $this->relMstId = $relMstId;
  }

  public function getRelMstName()
  {
    return $this->relMstName;
  }

  public function setRelMstName($relMstName)
  {
    $this->relMstName = $relMstName;
  }

  public function getOpusId()
  {
    return $this->opusId;
  }

  public function setOpusId($opusId)
  {
    $this->opusId = $opusId;
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
