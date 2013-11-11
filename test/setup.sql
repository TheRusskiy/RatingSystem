-- This file runs before every test suite

DROP TABLE IF EXISTS testings;
CREATE TABLE testings(
  id INT(10) NOT NULL AUTO_INCREMENT,
  time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(id)
);
INSERT into testings VALUES();

DROP TABLE IF EXISTS staff;
CREATE TABLE staff(
  id INT(10) NOT NULL,
  name VARCHAR (30),
  PRIMARY KEY(id)
);

INSERT INTO staff(id, name)
  VALUES
  (0, 'name_0'),
  (1, 'name_1'),
  (2, 'name_2'),
  (3, 'name_3'),
  (4, 'name_4'),
  (5, 'name_5'),
  (6, 'name_6');

DROP TABLE IF EXISTS ka_periods;
CREATE TABLE ka_periods (
  id int(18) NOT NULL auto_increment,
  end_date date default NULL,
  start_date date default NULL,
  name varchar(60) default NULL,
  UNIQUE KEY id (id),
  KEY start_date (start_date)
);
INSERT INTO ka_periods (id, end_date, start_date, name) VALUES
(104, '2009-12-31', '2009-12-21', 'C 21.12.2009 по 31.12.2009'),
(105, '2010-01-10', '2010-01-01', 'C 1.1.2010 по 10.1.2010'),
(107, '2010-01-20', '2010-01-11', 'C 11.1.2010 по 20.1.2010'),
(108, '2010-01-31', '2010-01-21', 'C 21.1.2010 по 31.1.2010'),
(109, '2010-02-10', '2010-02-01', 'C 1.2.2010 по 10.2.2010'),
(110, '2010-02-20', '2010-02-11', 'C 11.2.2010 по 20.2.2010'),
(111, '2010-02-28', '2010-02-21', 'C 21.2.2010 по 28.2.2010')
;

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

INSERT INTO rating_entries (staff_id, criteria_id, date, value)
  VALUES
  (0, 4, '2013-01-01', 1),
  (1, 4, '2010-01-01', 1),
  (1, 4, '2013-01-01', 1),
  (1, 4, '2013-02-01', 1),
  (1, 4, '2013-03-01', 2),
  (1, 4, '2015-02-01', 1),

  (1, 5, '2013-01-01', 0),
  (1, 5, '2010-01-01', 0),
  (1, 5, '2013-01-01', 1),
  (1, 5, '2013-01-01', 2),
  (1, 5, '2013-02-01', 3),
  (1, 5, '2015-02-01', 3)
;