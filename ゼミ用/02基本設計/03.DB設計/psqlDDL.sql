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

DROP TABLE IF EXISTS common_mst;

DROP TABLE IF EXISTS rel;

DROP TABLE IF EXISTS actor;

DROP TABLE IF EXISTS group_mst;

DROP TABLE IF EXISTS time_mst;

DROP TABLE IF EXISTS rel_mst;

DROP TABLE IF EXISTS opus;

DROP TABLE IF EXISTS cor_user;

/* ユーザテーブル */
CREATE TABLE cor_user(
    user_id VARCHAR(10) NOT NULL,
    user_name VARCHAR(100),
    password VARCHAR(100) NOT NULL,
    version SMALLINT NOT NULL DEFAULT 0,
    PRIMARY KEY(user_id)
);

/* 作品マスタ */
CREATE TABLE opus(
    opus_id VARCHAR(8) NOT NULL,
    opus_name VARCHAR(100) NOT NULL,
    opus_flg SMALLINT NOT NULL DEFAULT 0,
    user_id VARCHAR(10) NOT NULL,
    version SMALLINT NOT NULL DEFAULT 0,
    PRIMARY KEY(opus_id),
    FOREIGN KEY(user_id) REFERENCES cor_user(user_id) ON DELETE CASCADE ON UPDATE CASCADE
);

/* 関係性マスタ */
CREATE TABLE rel_mst(
    rel_mst_id VARCHAR(10) NOT NULL,
    rel_mst_name VARCHAR(100),
    opus_id VARCHAR(8) NOT NULL,
    user_id VARCHAR(10) NOT NULL,
    version SMALLINT DEFAULT 0,
    PRIMARY KEY(rel_mst_id),
    FOREIGN KEY(opus_id) REFERENCES opus(opus_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(user_id) REFERENCES cor_user(user_id) ON DELETE CASCADE ON UPDATE CASCADE
);

/* 時系列マスタ */
CREATE TABLE time_mst(
    time_id VARCHAR(8) NOT NULL,
    time_name VARCHAR(100) NOT NULL,
    opus_id VARCHAR(8) NOT NULL,
    user_id VARCHAR(10) NOT NULL,
    version SMALLINT NOT NULL DEFAULT 0,
    PRIMARY KEY(time_id),
    FOREIGN KEY(opus_id) REFERENCES opus(opus_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(user_id) REFERENCES cor_user(user_id) ON DELETE CASCADE ON UPDATE CASCADE
);

/* グループマスタ */
CREATE TABLE group_mst(
    group_id VARCHAR(9) NOT NULL,
    group_name VARCHAR(100) NOT NULL,
    group_info VARCHAR(1200),
    group_color VARCHAR(100) NOT NULL,
    opus_id VARCHAR(8) NOT NULL,
    time_id VARCHAR(8) NOT NULL,
    user_id VARCHAR(10) NOT NULL,
    version SMALLINT NOT NULL DEFAULT 0,
    PRIMARY KEY(group_id),
    FOREIGN KEY(opus_id) REFERENCES opus(opus_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(time_id) REFERENCES time_mst(time_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(user_id) REFERENCES cor_user(user_id) ON DELETE CASCADE ON UPDATE CASCADE
);

/* 登場人物マスタ */
CREATE TABLE actor(
    actor_id VARCHAR(8) NOT NULL,
    actor_name VARCHAR(100) NOT NULL,
    actor_info VARCHAR(1200),
    actor_img VARCHAR,
    opus_id VARCHAR(8) NOT NULL,
    time_id VARCHAR(8) NOT NULL,
    group_id VARCHAR(9) NOT NULL,
    user_id VARCHAR(10) NOT NULL,
    version SMALLINT NOT NULL DEFAULT 0,
    PRIMARY KEY(actor_id),
    FOREIGN KEY(opus_id) REFERENCES opus(opus_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(time_id) REFERENCES time_mst(time_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(group_id) REFERENCES group_mst(group_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(user_id) REFERENCES cor_user(user_id) ON DELETE CASCADE ON UPDATE CASCADE
);

/* 関係テーブル */
CREATE TABLE rel(
    rel_id VARCHAR(9) NOT NULL UNIQUE,
    rel_mst_id VARCHAR(10) NOT NULL,
    rel_mst_info VARCHAR(1200),
    actor_id VARCHAR(8) NOT NULL,
    target_id VARCHAR(8) NOT NULL,
    opus_id VARCHAR(8) NOT NULL,
    time_id VARCHAR(8) NOT NULL,
    user_id VARCHAR(10) NOT NULL,
    version SMALLINT NOT NULL DEFAULT 0,
    PRIMARY KEY(rel_id),
    FOREIGN KEY(rel_mst_id) REFERENCES rel_mst(rel_mst_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(actor_id) REFERENCES actor(actor_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(target_id) REFERENCES actor(actor_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(opus_id) REFERENCES opus(opus_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(time_id) REFERENCES time_mst(time_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(user_id) REFERENCES cor_user(user_id) ON DELETE CASCADE ON UPDATE CASCADE
);

/* 汎用マスタ */
CREATE TABLE common_mst(
    common_id SERIAL NOT NULL,
    common_key VARCHAR(1200) NOT NULL,
    common_value VARCHAR(1200) NOT NULL,
    common_info VARCHAR(1200) NOT NULL,
    PRIMARY KEY(common_id)
);

INSERT INTO
    common_mst(common_key, common_value, common_info)
VALUES
    ('_color', '#808080', 'グレー'),
    ('_color', '#FF69B4', 'ピンク'),
    ('_color', '#8B4513', 'ブラウン'),
    ('_color', '#FFA500', 'オレンジ'),
    ('_color', '#FFFF00', '黄'),
    ('_color', '#800080', '紫'),
    ('_color', '#2AFF00', '緑'),
    ('_color', '#00C3FF', '青'),
    ('_color', '#FF193F', '赤');

INSERT INTO
    cor_user (user_id, user_name, password, version)
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