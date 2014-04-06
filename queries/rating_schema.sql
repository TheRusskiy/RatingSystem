use diploma_development;
DROP TABLE IF EXISTS criteria;
CREATE TABLE criteria (
  id INT(17) NOT NULL auto_increment,
  name VARCHAR(120) NOT NULL ,
  description VARCHAR(2000) NOT NULL ,
  fetch_type VARCHAR(30) NOT NULL ,
  fetch_value VARCHAR(4000) NOT NULL,
  multiplier VARCHAR(30),
  calculation_type VARCHAR(30) NOT NULL ,
  year_limit INT(10),
  creation_date DATE,
  PRIMARY KEY(id)
);

DROP TABLE IF EXISTS rating_records;
CREATE TABLE rating_records (
  id INT(17) NOT NULL auto_increment,
  staff_id INT(10) NOT NULL ,
  criteria_id INT(10) NOT NULL ,
  user_id INT(10) NOT NULL ,
  name VARCHAR(100) NOT NULL ,
  date DATE NOT NULL ,
  value INT(10) NOT NULL DEFAULT 1,
  PRIMARY KEY(id),
  INDEX staff_criteria (staff_id, criteria_id)
);

DROP TABLE IF EXISTS cached_rating;
CREATE TABLE cached_rating (
  id INT(17) NOT NULL auto_increment,
  staff_id INT(10) NOT NULL,
  date_from DATE NOT NULL,
  date_to DATE NOT NULL,
  value INT(10) NOT NULL,
  is_data_complete INT(1) NOT NULL,
  PRIMARY KEY(id),
  INDEX staff_dates (staff_id, date_from, date_to)
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

# DROP TABLE IF EXISTS verification_user_role;
# CREATE TABLE verification_user_role (
#   id INT(17) NOT NULL auto_increment,
#   user_id INT(10) NOT NULL UNIQUE,
#   permissions VARCHAR(100)
# );
