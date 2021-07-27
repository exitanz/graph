<?php

/**
 * 時系列マスタを格納するクラス
 */
class TimeMst
{

  private $timeId;
  private $timeName;
  private $opusId;
  private $userId;
  private $version;

  public function getTimeId()
  {
    return $this->timeId;
  }

  public function setTimeId($timeId)
  {
    $this->timeId = $timeId;
  }

  public function getTimeName()
  {
    return $this->timeName;
  }

  public function setTimeName($timeName)
  {
    $this->timeName = $timeName;
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
