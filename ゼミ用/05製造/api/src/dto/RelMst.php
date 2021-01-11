<?php

/**
 * 関係マスタを格納するクラス
 */
class RelMst {

  private $relMstId;
  private $relMstName;
  private $groupId;
  private $version;

  public function getRelMstId() {
    return $this->relMstId;
  }

  public function setRelMstId($relMstId) {
    $this->relMstId = $relMstId;
  }

  public function getRelMstName() {
    return $this->relMstName;
  }

  public function setRelMstName($relMstName) {
    $this->relMstName = $relMstName;
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
