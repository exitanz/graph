/* 既存データベースがある場合は削除 */
DROP DATABASE IF EXISTS dkgraph_correlation;
/* データベース作成 */
CREATE DATABASE dkgraph_correlation;
/* データベース選択 */
use dkgraph_correlation;
/* 既存ユーザが存在する場合は削除 */
DROP USER IF EXISTS 'dkgraph_exit';
/* ユーザ作成 */
CREATE USER dkgraph_exit IDENTIFIED BY 'g20e38h41AAbf';
/* dkgraph_exitにデータベース捜査全ての権限を与える */
GRANT ALL ON dkgraph_exit.* TO 'dkgraph_exit';

DROP TABLE IF EXISTS rel;
DROP TABLE IF EXISTS acter;
DROP TABLE IF EXISTS group_mst;
DROP TABLE IF EXISTS time_mst;
DROP TABLE IF EXISTS rel_mst;
DROP TABLE IF EXISTS opus;
DROP TABLE IF EXISTS cor_user;

/* ユーザテーブル */
CREATE TABLE cor_user(
user_id VARCHAR(10) NOT NULL COMMENT 'ユーザID' ,
user_name VARCHAR(100) ,
password VARCHAR(100) NOT NULL ,
version SMALLINT UNSIGNED NOT NULL DEFAULT 0 ,
PRIMARY KEY(user_id)
);

/* 作品マスタ */
CREATE TABLE opus(
opus_id VARCHAR(8) NOT NULL ,
opus_name VARCHAR(100) NOT NULL ,
user_id VARCHAR(10) NOT NULL ,
version SMALLINT UNSIGNED NOT NULL DEFAULT 0 ,
PRIMARY KEY(opus_id)
,FOREIGN KEY(user_id) REFERENCES cor_user(user_id)
);

/* 関係性マスタ */
CREATE TABLE rel_mst(
rel_mst_id VARCHAR(10) NOT NULL ,
rel_mst_name VARCHAR(100) ,
opus_id VARCHAR(8) NOT NULL ,
user_id VARCHAR(10) NOT NULL ,
version SMALLINT UNSIGNED DEFAULT 0 ,
PRIMARY KEY(rel_mst_id)
,FOREIGN KEY(opus_id) REFERENCES opus(opus_id)
,FOREIGN KEY(user_id) REFERENCES cor_user(user_id)
);

/* 時系列マスタ */
CREATE TABLE time_mst(
time_id VARCHAR(8) NOT NULL ,
time_name VARCHAR(100) NOT NULL ,
opus_id VARCHAR(8) NOT NULL ,
user_id VARCHAR(10) NOT NULL ,
version SMALLINT UNSIGNED NOT NULL DEFAULT 0 ,
PRIMARY KEY(time_id)
,FOREIGN KEY(opus_id) REFERENCES opus(opus_id)
,FOREIGN KEY(user_id) REFERENCES cor_user(user_id)
);

/* グループマスタ */
CREATE TABLE group_mst(
group_id VARCHAR(9) NOT NULL ,
group_name VARCHAR(100) NOT NULL ,
group_info VARCHAR(1200) ,
opus_id VARCHAR(8) NOT NULL ,
time_id VARCHAR(8) NOT NULL ,
user_id VARCHAR(10) NOT NULL ,
version SMALLINT UNSIGNED NOT NULL DEFAULT 0 ,
PRIMARY KEY(group_id)
,FOREIGN KEY(opus_id) REFERENCES opus(opus_id)
,FOREIGN KEY(time_id) REFERENCES time_mst(time_id)
,FOREIGN KEY(user_id) REFERENCES cor_user(user_id)
);

/* 登場人物マスタ */
CREATE TABLE acter(
acter_id VARCHAR(8) NOT NULL ,
acter_name VARCHAR(100) NOT NULL ,
acter_info VARCHAR(1200) ,
acter_img VARCHAR(2000) ,
opus_id VARCHAR(8) NOT NULL ,
time_id VARCHAR(8) NOT NULL ,
group_id VARCHAR(9) NOT NULL ,
user_id VARCHAR(10) NOT NULL ,
version SMALLINT UNSIGNED NOT NULL DEFAULT 0 ,
PRIMARY KEY(acter_id)
,FOREIGN KEY(opus_id) REFERENCES opus(opus_id)
,FOREIGN KEY(time_id) REFERENCES time_mst(time_id)
,FOREIGN KEY(group_id) REFERENCES group_mst(group_id)
,FOREIGN KEY(user_id) REFERENCES cor_user(user_id)
);

/* 関係 */
CREATE TABLE rel(
rel_id VARCHAR(9) NOT NULL UNIQUE  ,
rel_mst_id VARCHAR(10) NOT NULL ,
rel_mst_info VARCHAR(1200) ,
acter_id VARCHAR(8) NOT NULL ,
target_id VARCHAR(8) NOT NULL ,
opus_id VARCHAR(8) NOT NULL ,
time_id VARCHAR(8) NOT NULL ,
user_id VARCHAR(10) NOT NULL ,
version SMALLINT UNSIGNED NOT NULL DEFAULT 0 ,
PRIMARY KEY(rel_id)
,FOREIGN KEY(rel_mst_id) REFERENCES rel_mst(rel_mst_id)
,FOREIGN KEY(acter_id) REFERENCES acter(acter_id)
,FOREIGN KEY(target_id) REFERENCES acter(acter_id)
,FOREIGN KEY(opus_id) REFERENCES opus(opus_id)
,FOREIGN KEY(time_id) REFERENCES time_mst(time_id)
,FOREIGN KEY(user_id) REFERENCES cor_user(user_id)
);

INSERT INTO `cor_user` (`user_id`, `user_name`, `password`, `version`) VALUES
('user000001', 'test1', '$5$rounds=5000$usesomesillystri$NiHLsMQsOUSx.Yuhrc2x/yweqSXOCBEOqmTYEjEiAU8', 0);

INSERT INTO `cor_user` (`user_id`, `user_name`, `password`, `version`) VALUES
('user000002', 'test2', '$5$rounds=5000$usesomesillystri$NiHLsMQsOUSx.Yuhrc2x/yweqSXOCBEOqmTYEjEiAU8', 0);

INSERT INTO `cor_user` (`user_id`, `user_name`, `password`, `version`) VALUES
('user000003', 'test3', '$5$rounds=5000$usesomesillystri$NiHLsMQsOUSx.Yuhrc2x/yweqSXOCBEOqmTYEjEiAU8', 0);