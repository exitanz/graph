<?php

/**
 * グループマスタを格納するクラス
 */
class GroupMst
{

  private $groupId;
  private $groupName;
  private $groupInfo;
  private $opusId;
  private $timeId;
  private $userId;
  private $version;

  public function getGroupId()
  {
    return $this->groupId;
  }

  public function setGroupId($groupId)
  {
    $this->groupId = $groupId;
  }

  public function getGroupName()
  {
    return $this->groupName;
  }

  public function setGroupName($groupName)
  {
    $this->groupName = $groupName;
  }

  public function getGroupInfo()
  {
    return $this->groupInfo;
  }

  public function setGroupInfo($groupInfo)
  {
    $this->groupInfo = $groupInfo;
  }

  public function getOpusId()
  {
    return $this->opusId;
  }

  public function setOpusId($opusId)
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
