<?php

/**
 * 関係を格納するクラス
 */
class Rel
{

  private $relId;
  private $relMstId;
  private $relMstInfo;
  private $acterId;
  private $targetId;
  private $opusId;
  private $timeId;
  private $userId;
  private $version;

  public function getRelId()
  {
    return $this->relId;
  }

  public function setRelId($relId)
  {
    $this->relId = $relId;
  }

  public function getRelMstId()
  {
    return $this->relMstId;
  }

  public function setRelMstId($relMstId)
  {
    $this->relMstId = $relMstId;
  }

  public function getRelMstInfo()
  {
    return $this->relMstInfo;
  }

  public function setRelMstInfo($relMstInfo)
  {
    $this->relMstInfo = $relMstInfo;
  }

  public function getActerId()
  {
    return $this->acterId;
  }

  public function setActerId($acterId)
  {
    $this->acterId = $acterId;
  }

  public function getTargetId()
  {
    return $this->targetId;
  }

  public function setTargetId($targetId)
  {
    $this->targetId = $targetId;
  }

  public function getOpusId()
  {
    return $this->opusId;
  }

  public function setOpustId($opusId)
  {
    $this->opusId = $opusId;
  }

  public function getTimeId()
  {
    return $this->timeId;
  }

  public function setTimeId($timeId)
  {
    $this->timeId = $timeId;
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
