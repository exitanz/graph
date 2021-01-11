<?php

/**
 * 登場人物を格納するクラス
 */
class Acter {

  private $acterId;
  private $acterName;
  private $acterConf;
  private $acterImg;
  private $timeId;
  private $groupId;
  private $version;

  public function getActerId() {
    return $this->acterId;
  }

  public function setActerId($acterId) {
    $this->acterId = $acterId;
  }

  public function getActerName() {
    return $this->acterName;
  }

  public function setActerName($acterName) {
    $this->acterName = $acterName;
  }

  public function getActerConf() {
    return $this->acterConf;
  }

  public function setActerConf($acterConf) {
    $this->acterConf = $acterConf;
  }

  public function getActerImg() {
    return $this->acterImg;
  }

  public function setActerImg($acterImg) {
    $this->acterImg = $acterImg;
  }

  public function getTimeId() {
    return $this->timeId;
  }

  public function setTimeId($timeId) {
    $this->timeId = $timeId;
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
