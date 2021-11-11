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
    user_id TEXT NOT NULL ,
    user_name TEXT ,
    password TEXT NOT NULL ,
    version INTEGER UNSIGNED NOT NULL DEFAULT 0 ,
    PRIMARY KEY(user_id)
) ;

/* 作品マスタ */
CREATE TABLE opus(
    opus_id TEXT NOT NULL ,
    opus_name TEXT NOT NULL ,
    opus_flg INTEGER UNSIGNED NOT NULL DEFAULT 0 ,
    user_id TEXT NOT NULL ,
    version INTEGER UNSIGNED NOT NULL DEFAULT 0 ,
    PRIMARY KEY(opus_id),
    FOREIGN KEY(user_id) REFERENCES cor_user(user_id) ON DELETE CASCADE ON UPDATE CASCADE
) ;

/* 関係性マスタ */
CREATE TABLE rel_mst(
    rel_mst_id TEXT NOT NULL ,
    rel_mst_name TEXT ,
    opus_id TEXT NOT NULL ,
    user_id TEXT NOT NULL ,
    version INTEGER UNSIGNED DEFAULT 0 ,
    PRIMARY KEY(rel_mst_id),
    FOREIGN KEY(opus_id) REFERENCES opus(opus_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(user_id) REFERENCES cor_user(user_id) ON DELETE CASCADE ON UPDATE CASCADE
) ;

/* 時系列マスタ */
CREATE TABLE time_mst(
    time_id TEXT NOT NULL ,
    time_name TEXT NOT NULL ,
    opus_id TEXT NOT NULL ,
    user_id TEXT NOT NULL ,
    version INTEGER UNSIGNED NOT NULL DEFAULT 0 ,
    PRIMARY KEY(time_id),
    FOREIGN KEY(opus_id) REFERENCES opus(opus_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(user_id) REFERENCES cor_user(user_id) ON DELETE CASCADE ON UPDATE CASCADE
) ;

/* グループマスタ */
CREATE TABLE group_mst(
    group_id TEXT NOT NULL ,
    group_name TEXT NOT NULL ,
    group_info TEXT ,
    group_color TEXT NOT NULL ,
    opus_id TEXT NOT NULL ,
    time_id TEXT NOT NULL ,
    user_id TEXT NOT NULL ,
    version INTEGER UNSIGNED NOT NULL DEFAULT 0 ,
    PRIMARY KEY(group_id),
    FOREIGN KEY(opus_id) REFERENCES opus(opus_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(time_id) REFERENCES time_mst(time_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(user_id) REFERENCES cor_user(user_id) ON DELETE CASCADE ON UPDATE CASCADE
) ;

/* 登場人物マスタ */
CREATE TABLE actor(
    actor_id TEXT NOT NULL ,
    actor_name TEXT NOT NULL ,
    actor_info TEXT ,
    actor_img TEXT ,
    opus_id TEXT NOT NULL ,
    time_id TEXT NOT NULL ,
    group_id TEXT NOT NULL ,
    user_id TEXT NOT NULL ,
    version INTEGER UNSIGNED NOT NULL DEFAULT 0 ,
    PRIMARY KEY(actor_id),
    FOREIGN KEY(opus_id) REFERENCES opus(opus_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(time_id) REFERENCES time_mst(time_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(group_id) REFERENCES group_mst(group_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(user_id) REFERENCES cor_user(user_id) ON DELETE CASCADE ON UPDATE CASCADE
) ;

/* 関係テーブル */
CREATE TABLE rel(
    rel_id TEXT NOT NULL UNIQUE ,
    rel_mst_id TEXT NOT NULL ,
    rel_mst_info TEXT ,
    actor_id TEXT NOT NULL ,
    target_id TEXT NOT NULL ,
    opus_id TEXT NOT NULL ,
    time_id TEXT NOT NULL ,
    user_id TEXT NOT NULL ,
    version INTEGER UNSIGNED NOT NULL DEFAULT 0 ,
    PRIMARY KEY(rel_id),
    FOREIGN KEY(rel_mst_id) REFERENCES rel_mst(rel_mst_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(actor_id) REFERENCES actor(actor_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(target_id) REFERENCES actor(actor_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(opus_id) REFERENCES opus(opus_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(time_id) REFERENCES time_mst(time_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(user_id) REFERENCES cor_user(user_id) ON DELETE CASCADE ON UPDATE CASCADE
) ;

/* 汎用マスタ */
CREATE TABLE common_mst(
    common_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT ,
    common_key TEXT NOT NULL ,
    common_value TEXT NOT NULL ,
    common_info TEXT NOT NULL
) ;

INSERT INTO
    `common_mst`(`common_key`, `common_value`, `common_info`)
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