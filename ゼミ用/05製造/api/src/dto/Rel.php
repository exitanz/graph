<?php

/**
 * 関係を格納するクラス
 */
class Rel {

  private $relId;
  private $relMstId;
  private $acterId;
  private $selectId;
  private $userId;
  private $version;

  public function getRelId() {
    return $this->relId;
  }

  public function setRelId($relId) {
    $this->relId = $relId;
  }

  public function getRelMstId() {
    return $this->relMstId;
  }

  public function setRelMstId($relMstId) {
    $this->relMstId = $relMstId;
  }

  public function getActerId() {
    return $this->acterId;
  }

  public function setActerId($acterId) {
    $this->acterId = $acterId;
  }

  public function getSelectId() {
    return $this->selectId;
  }

  public function setSelectId($selectId) {
    $this->selectId = $selectId;
  }

  public function getUserId() {
      return $this->userId;
  }

  public function setUserId($userId) {
      $this->userId = $userId;
  }

  public function getVersion() {
    return $this->version;
  }

  public function setVersion($version) {
    $this->version = $version;
  }
}
