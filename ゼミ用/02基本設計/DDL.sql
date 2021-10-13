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
    user_id VARCHAR(10) NOT NULL COMMENT 'ユーザID',
    user_name VARCHAR(100) COMMENT 'ユーザ名',
    password VARCHAR(100) NOT NULL COMMENT 'パスワード',
    version SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'バージョン',
    PRIMARY KEY(user_id)
) COMMENT 'ユーザテーブル';

/* 作品マスタ */
CREATE TABLE opus(
    opus_id VARCHAR(8) NOT NULL COMMENT '作品ID',
    opus_name VARCHAR(100) NOT NULL COMMENT '作品名',
    user_id VARCHAR(10) NOT NULL COMMENT 'ユーザID',
    version SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'バージョン',
    PRIMARY KEY(opus_id),
    FOREIGN KEY(user_id) REFERENCES cor_user(user_id) ON DELETE CASCADE ON UPDATE CASCADE
) COMMENT '作品マスタ';

/* 関係性マスタ */
CREATE TABLE rel_mst(
    rel_mst_id VARCHAR(10) NOT NULL COMMENT '関係性ID',
    rel_mst_name VARCHAR(100) COMMENT '関係性名',
    opus_id VARCHAR(8) NOT NULL COMMENT '作品ID',
    user_id VARCHAR(10) NOT NULL COMMENT 'ユーザID',
    version SMALLINT UNSIGNED DEFAULT 0 COMMENT 'バージョン',
    PRIMARY KEY(rel_mst_id),
    FOREIGN KEY(opus_id) REFERENCES opus(opus_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(user_id) REFERENCES cor_user(user_id) ON DELETE CASCADE ON UPDATE CASCADE
) COMMENT '関係性マスタ';

/* 時系列マスタ */
CREATE TABLE time_mst(
    time_id VARCHAR(8) NOT NULL COMMENT '時系列ID',
    time_name VARCHAR(100) NOT NULL COMMENT '時系列名',
    opus_id VARCHAR(8) NOT NULL COMMENT '作品ID',
    user_id VARCHAR(10) NOT NULL COMMENT 'ユーザID',
    version SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'バージョン',
    PRIMARY KEY(time_id),
    FOREIGN KEY(opus_id) REFERENCES opus(opus_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(user_id) REFERENCES cor_user(user_id) ON DELETE CASCADE ON UPDATE CASCADE
) COMMENT '時系列マスタ';

/* グループマスタ */
CREATE TABLE group_mst(
    group_id VARCHAR(9) NOT NULL COMMENT 'グループID',
    group_name VARCHAR(100) NOT NULL COMMENT 'グループ名',
    group_info VARCHAR(1200) COMMENT '詳細',
    group_color VARCHAR(100) NOT NULL COMMENT '色',
    opus_id VARCHAR(8) NOT NULL COMMENT '作品ID',
    time_id VARCHAR(8) NOT NULL COMMENT '時系列ID',
    user_id VARCHAR(10) NOT NULL COMMENT 'ユーザID',
    version SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'バージョン',
    PRIMARY KEY(group_id),
    FOREIGN KEY(opus_id) REFERENCES opus(opus_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(time_id) REFERENCES time_mst(time_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(user_id) REFERENCES cor_user(user_id) ON DELETE CASCADE ON UPDATE CASCADE
) COMMENT 'グループマスタ';

/* 登場人物マスタ */
CREATE TABLE acter(
    acter_id VARCHAR(8) NOT NULL COMMENT '登場人物ID',
    acter_name VARCHAR(100) NOT NULL COMMENT '登場人物名',
    acter_info VARCHAR(1200) COMMENT '説明',
    acter_img VARCHAR(2000) COMMENT '画像',
    opus_id VARCHAR(8) NOT NULL COMMENT '作品ID',
    time_id VARCHAR(8) NOT NULL COMMENT '時系列ID',
    group_id VARCHAR(9) NOT NULL COMMENT 'グループID',
    user_id VARCHAR(10) NOT NULL COMMENT 'ユーザID',
    version SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'バージョン',
    PRIMARY KEY(acter_id),
    FOREIGN KEY(opus_id) REFERENCES opus(opus_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(time_id) REFERENCES time_mst(time_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(group_id) REFERENCES group_mst(group_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(user_id) REFERENCES cor_user(user_id) ON DELETE CASCADE ON UPDATE CASCADE
) COMMENT '登場人物マスタ';

/* 関係テーブル */
CREATE TABLE rel(
    rel_id VARCHAR(9) NOT NULL UNIQUE COMMENT '関係ID',
    rel_mst_id VARCHAR(10) NOT NULL COMMENT '関係性ID',
    rel_mst_info VARCHAR(1200) COMMENT '関係詳細',
    acter_id VARCHAR(8) NOT NULL COMMENT '登場人物ID',
    target_id VARCHAR(8) NOT NULL COMMENT '対象ID',
    opus_id VARCHAR(8) NOT NULL COMMENT '作品ID',
    time_id VARCHAR(8) NOT NULL COMMENT '時系列ID',
    user_id VARCHAR(10) NOT NULL COMMENT 'ユーザID',
    version SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'バージョン',
    PRIMARY KEY(rel_id),
    FOREIGN KEY(rel_mst_id) REFERENCES rel_mst(rel_mst_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(acter_id) REFERENCES acter(acter_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(target_id) REFERENCES acter(acter_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(opus_id) REFERENCES opus(opus_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(time_id) REFERENCES time_mst(time_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(user_id) REFERENCES cor_user(user_id) ON DELETE CASCADE ON UPDATE CASCADE
) COMMENT '関係テーブル';

INSERT INTO
    `cor_user` (`user_id`, `user_name`, `password`, `version`)
VALUES
    (
        'user000001',
        'test',
        '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08',
        0
    ),
    (
        'user000002',
        'test',
        '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08',
        0
    ),
    (
        'user000003',
        'test',
        '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08',
        0
    );