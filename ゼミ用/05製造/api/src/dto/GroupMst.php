<?php

/**
 * グループマスタを格納するクラス
 */
class GroupMst {

  private $groupId;
  private $groupName;
  private $version;

  public function getGroupId() {
    return $this->groupId;
  }

  public function setGroupMstId($groupId) {
    $this->groupId = $groupId;
  }

  public function getGroupName() {
    return $this->groupName;
  }

  public function setGroupName($groupName) {
    $this->groupName = $groupName;
  }

  public function getVersion() {
    return $this->version;
  }

  public function setVersion($version) {
    $this->version = $version;
  }
}
