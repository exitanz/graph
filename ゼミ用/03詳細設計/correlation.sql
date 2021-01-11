/* ユーザ */
create table cor_user(user_id TEXT, user_name TEXT, password TEXT, version INTEGER);
/* 登場人物マスタ */
create table acter(acter_id TEXT, acter_name TEXT, acter_conf TEXT, acter_img TEXT, time_id TEXT, group_id TEXT, version INTEGER);
/* 時系列マスタ */
create table time_mst(time_id TEXT, time_name TEXT, group_id TEXT, version INTEGER);
/* 関係 */
create table rel(rel_id TEXT, rel_mst_id TEXT, acter_id TEXT, select_id TEXT, user_id TEXT, version INTEGER);
/* 関係性マスタ */
create table rel_mst(rel_mst_id TEXT, rel_mst_name TEXT, group_id TEXT, version INTEGER);
/* グループマスタ */
create table group_mst(group_id TEXT, group_name TEXT, user_id TEXT, version INTEGER);