DROP TABLE IF EXISTS criteria;
CREATE TABLE criteria (
  id INT(17) NOT NULL auto_increment,
  name VARCHAR(120) NOT NULL ,
  fetch_type VARCHAR(30) NOT NULL ,
  fetch_value VARCHAR(4000) NOT NULL,
  multiplier VARCHAR(30),
  calculation_type VARCHAR(30) NOT NULL ,
  year_limit INT(10),
  PRIMARY KEY(id)
);

DROP TABLE IF EXISTS rating_entries;
CREATE TABLE rating_entries (
  id INT(17) NOT NULL auto_increment,
  staff_id INT(10) NOT NULL ,
  criteria_id INT(10) NOT NULL ,
  date DATE NOT NULL ,
  value INT(10),
  PRIMARY KEY(id),
  INDEX staff_criteria (staff_id, criteria_id)
);
