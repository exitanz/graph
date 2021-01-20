/* ユーザ */
CREATE TABLE cor_user(
    user_id TEXT NOT NULL, user_name TEXT NOT NULL, password TEXT, version INTEGER NOT NULL,
    PRIMARY KEY (user_id),
    );
/* 登場人物マスタ */
CREATE TABLE acter(
    acter_id TEXT NOT NULL, acter_name TEXT NOT NULL, acter_conf TEXT, acter_img TEXT, time_id TEXT NOT NULL, group_id TEXT NOT NULL, version INTEGER NOT NULL
    PRIMARY KEY (acter_id),
    FOREIGN KEY (time_id) REFERENCES time_mst(time_id)
    FOREIGN KEY (group_id) REFERENCES group_mst(group_id)
    );
/* 時系列マスタ */
CREATE TABLE time_mst(
    time_id TEXT NOT NULL, time_name TEXT NOT NULL, group_id TEXT NOT NULL, version INTEGER NOT NULL
    PRIMARY KEY (time_id),
    FOREIGN KEY (group_id) REFERENCES group_mst(group_id)
    );
/* 関係 */
CREATE TABLE rel(
    rel_id TEXT NOT NULL, rel_mst_id TEXT NOT NULL, acter_id TEXT NOT NULL, select_id TEXT NOT NULL, user_id TEXT NOT NULL, version INTEGER NOT NULL
    PRIMARY KEY (rel_id),
    FOREIGN KEY (rel_mst_id) REFERENCES rel_mst(rel_mst_id)
    FOREIGN KEY (acter_id) REFERENCES acter(acter_id)
    /*FOREIGN KEY (select_id) REFERENCES time_mst(select_id) */
    FOREIGN KEY (user_id) REFERENCES cor_user(user_id)
    );
/* 関係性マスタ */
CREATE TABLE rel_mst(
    rel_mst_id TEXT NOT NULL, rel_mst_name TEXT NOT NULL, group_id TEXT NOT NULL, version INTEGER NOT NULL
    PRIMARY KEY (rel_mst_id),
    FOREIGN KEY (group_id) REFERENCES group_mst(group_id)
    );
/* グループマスタ */
CREATE TABLE group_mst(
    group_id TEXT NOT NULL, group_name TEXT NOT NULL, user_id TEXT NOT NULL, version INTEGER NOT NULL
    PRIMARY KEY (group_id)
    FOREIGN KEY (user_id) REFERENCES cor_user(user_id)
    );
