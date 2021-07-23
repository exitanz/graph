/* �����f�[�^�x�[�X������ꍇ�͍폜 */
DROP DATABASE IF EXISTS correlation;
/* �f�[�^�x�[�X�쐬 */
CREATE DATABASE correlation;
/* �f�[�^�x�[�X�I�� */
use correlation;
/* �������[�U�����݂���ꍇ�͍폜 */
DROP USER IF EXISTS exit_v1;
/* ���[�U�쐬 */
CREATE USER exit_v1 IDENTIFIED BY 'g20e38h41AAbf';

DROP TABLE IF EXISTS rel;
DROP TABLE IF EXISTS acter;
DROP TABLE IF EXISTS group_mst;
DROP TABLE IF EXISTS time_mst;
DROP TABLE IF EXISTS rel_mst;
DROP TABLE IF EXISTS opus;
DROP TABLE IF EXISTS cor_user;

/* ���[�U�e�[�u�� */
CREATE TABLE cor_user(
user_id VARCHAR(10) NOT NULL ,
user_name VARCHAR(100) ,
password VARCHAR(100) NOT NULL ,
version SMALLINT UNSIGNED NOT NULL DEFAULT 0 ,
PRIMARY KEY(user_id)
);

/* ��i�}�X�^ */
CREATE TABLE opus(
opus_id VARCHAR(8) NOT NULL ,
opus_name VARCHAR(100) NOT NULL ,
user_id VARCHAR(10) NOT NULL ,
version SMALLINT UNSIGNED NOT NULL DEFAULT 0 ,
PRIMARY KEY(opus_id)
,FOREIGN KEY(user_id) REFERENCES cor_user(user_id)
);

/* �֌W���}�X�^ */
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

/* ���n��}�X�^ */
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

/* �O���[�v�}�X�^ */
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

/* �o��l���}�X�^ */
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

/* �֌W */
DROP TABLE IF EXISTS rel;
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
