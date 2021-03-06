use diploma_development;

DROP TABLE IF EXISTS criteria;
CREATE TABLE criteria (
  id INT(17) NOT NULL auto_increment,
  name VARCHAR(120) NOT NULL ,
  description VARCHAR(2000) NOT NULL ,
  fetch_type VARCHAR(30) NOT NULL ,
  fetch_value VARCHAR(4000) NOT NULL,
  external_records TINYINT(1) DEFAULT 0,
  PRIMARY KEY(id)
);

DROP TABLE IF EXISTS criteria_versions;
CREATE TABLE criteria_versions (
  id INT(17) NOT NULL auto_increment,
  criteria_id INT(17) NOT NULL,
  multiplier VARCHAR(30),
  year_limit INT(10) NOT NULL DEFAULT 0,
  year_2_limit INT(10) NOT NULL DEFAULT 0,
  creation_date DATE,
  PRIMARY KEY(id)
);

DROP TABLE IF EXISTS rating_seasons_criteria_versions;
CREATE TABLE rating_seasons_criteria_versions (
  id INT(17) NOT NULL auto_increment,
  criteria_version_id INT(17) NOT NULL,
  rating_season_id INT(17) NOT NULL,
  version_order INT(17) NOT NULL,
  PRIMARY KEY(id)
);

DROP TABLE IF EXISTS rating_records;
CREATE TABLE rating_records (
  id INT(17) NOT NULL auto_increment,
  staff_id INT(10) NOT NULL ,
  criteria_id INT(10) NOT NULL ,
  user_id INT(10) NOT NULL ,
  name VARCHAR(600) NOT NULL ,
  date DATE NOT NULL ,
  value INT(10) NOT NULL DEFAULT 1,
  PRIMARY KEY(id),
  INDEX staff_criteria (staff_id, criteria_id)
);

DROP TABLE IF EXISTS rating_external_records;
CREATE TABLE rating_external_records (
  id INT(17) NOT NULL auto_increment,
  staff_id INT(10) NOT NULL ,
  criteria_id INT(10) NOT NULL ,
  created_by INT(10) NOT NULL ,
  reviewed_by INT(10),
  description VARCHAR(600) NOT NULL ,
  date DATE NOT NULL ,
  status VARCHAR(30) NOT NULL ,
  PRIMARY KEY(id),
  INDEX status_criteria (staff_id, criteria_id)
);

DROP TABLE IF EXISTS rating_cache;
CREATE TABLE rating_cache (
  `key` VARCHAR(200) NOT NULL ,
  value LONGTEXT NOT NULL,
  time_to_live INT(10) NOT NULL DEFAULT 0,
  created_at TIMESTAMP NOT NULL,
  PRIMARY KEY(`key`)
);

DROP TABLE IF EXISTS rating_record_notes;
CREATE TABLE rating_record_notes (
  id INT(17) NOT NULL auto_increment,
  record_id INT(10) NOT NULL,
  user_id INT(10) NOT NULL,
  date DATE NOT NULL,
  text VARCHAR(500) NOT NULL ,
  PRIMARY KEY(id)
);

DROP TABLE IF EXISTS rating_record_external_notes;
CREATE TABLE rating_record_external_notes (
  id INT(17) NOT NULL auto_increment,
  record_id INT(10) NOT NULL,
  user_id INT(10) NOT NULL,
  date DATE NOT NULL,
  text VARCHAR(500) NOT NULL ,
  PRIMARY KEY(id)
);

DROP TABLE IF EXISTS rating_user_permissions;
CREATE TABLE rating_user_permissions (
  id INT(17) NOT NULL,
  permissions VARCHAR(1000) NOT NULL ,
  role VARCHAR(100) NOT NULL ,
  PRIMARY KEY(id)
);

DROP TABLE IF EXISTS rating_seasons;
CREATE TABLE rating_seasons (
  id INT(17) NOT NULL,
  from_date DATE NOT NULL,
  to_date DATE NOT NULL,
  PRIMARY KEY(id)
);
