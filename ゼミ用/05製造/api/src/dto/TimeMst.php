<?php

/**
 * 時系列マスタを格納するクラス
 */
class TimeMst {

  private $timeId;
  private $timeName;
  private $groupId;
  private $version;

  public function getTimeId() {
    return $this->timeId;
  }

  public function setTimeId($timeId) {
    $this->timeId = $timeId;
  }

  public function getTimeName() {
    return $this->timeName;
  }

  public function setTimeName($timeName) {
    $this->timeName = $timeName;
  }

  public function getGroupId() {
    return $this->groupId;
  }

  public function setGroupId($groupId) {
    $this->groupId = $groupId;
  }

  public function getVersion() {
    return $this->version;
  }

  public function setVersion($version) {
    $this->version = $version;
  }
}
