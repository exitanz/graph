<?php

/**
 * 登場人物を格納するクラス
 */
class Acter {

  private $acterId;
  private $acterName;
  private $acterInfo;
  private $acterImg;
  private $opusId;
  private $timeId;
  private $groupId;
  private $userId;
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

  public function getActerInfo() {
    return $this->acterInfo;
  }

  public function setActerInfo($acterInfo) {
    $this->acterInfo = $acterInfo;
  }

  public function getActerImg() {
    return $this->acterImg;
  }

  public function setActerImg($acterImg) {
    $this->acterImg = $acterImg;
  }

  public function getOpusId()
  {
    return $this->opusId;
  }

  public function setOpusId($opusId)
  {
    $this->opusId = $opusId;
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

  public function getUserId()
  {
    return $this->userId;
  }

  public function setUserId($userId)
  {
    $this->userId = $userId;
  }

  public function getVersion() {
    return $this->version;
  }

  public function setVersion($version) {
    $this->version = $version;
  }
}
