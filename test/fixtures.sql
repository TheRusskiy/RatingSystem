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

DROP TABLE IF EXISTS some_entries;
CREATE TABLE some_entries(
  id INT(10) NOT NULL AUTO_INCREMENT,
  staff_id INT(17) NOT NULL,
  period_id INT(17) NOT NULL,
  PRIMARY KEY(id)
);
INSERT INTO some_entries (staff_id, period_id)
  VALUES
  (1, 104), -- 2009-12-31
  (1, 105), -- 2010-01-10
  (1, 107), -- 2010-01-20
  (2, 104), -- 2009-12-31
  (2, 105), -- 2010-01-10
  (2, 107), -- 2010-01-20
  (2, 169), -- 2011-10-10
  (2, 4790), -- 2013-02-28
  (2, 4791), -- 2013-03-10
  (2, 4792); -- 2013-03-20
INSERT INTO some_entries (staff_id, period_id)
  VALUES
  (3, 154), -- 2011-05-01
  (3, 155), -- 2011-05-11
  (3, 156), -- 2011-05-21
  (3, 181), -- 2012-02-10
  (3, 182), -- 2012-02-20
  (3, 183), -- 2012-02-29
  (3, 4759), -- 2012-04-20
  (3, 4760), -- 2012-04-30
  (3, 4761), -- 2012-05-10
  (3, 4791), -- 2013-03-10
  (3, 4792); -- 2013-03-20

DROP TABLE IF EXISTS rating_records;
CREATE TABLE rating_records (
  id INT(17) NOT NULL auto_increment,
  staff_id INT(10) NOT NULL ,
  criteria_id INT(10) NOT NULL ,
  date DATE NOT NULL ,
  value INT(10),
  PRIMARY KEY(id),
  INDEX staff_criteria (staff_id, criteria_id)
);

INSERT INTO rating_records (staff_id, criteria_id, date, value)
  VALUES
  (1, 4, '2010-01-01', 1),
  (0, 4, '2013-01-01', 1),
  (1, 4, '2013-01-01', 1),
  (1, 4, '2013-02-01', 1),
  (1, 4, '2013-03-01', 2),
  (1, 4, '2015-02-01', 1),
  (1, 5, '2010-01-01', 0),
  (1, 5, '2013-01-01', 0),
  (1, 5, '2013-01-01', 1),
  (1, 5, '2013-01-02', 2),
  (1, 5, '2013-01-02', 0),
  (1, 5, '2013-01-02', 1),
  (1, 5, '2013-02-01', 3),
  (1, 5, '2015-02-01', 3)
;

-- Stupid mysql only allows conditionals and other stuff when it's it a procedure
DELIMITER $$
DROP PROCEDURE IF EXISTS setup_script$$

CREATE PROCEDURE setup_script ()
  BEGIN

    -- Following inserts data only once if table doesn't exist
    IF (SELECT count(*)
        FROM information_schema.tables
        WHERE table_schema = (select database()) -- current DB
              AND table_name = 'ka_periods'
        LIMIT 1) <1 THEN
      BEGIN

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
        (111, '2010-02-28', '2010-02-21', 'C 21.2.2010 по 28.2.2010'),
        (112, '2010-03-10', '2010-03-01', 'C 1.3.2010 по 10.3.2010'),
        (113, '2010-03-20', '2010-03-11', 'C 11.3.2010 по 20.3.2010'),
        (114, '2010-03-31', '2010-03-21', 'C 21.3.2010 по 31.3.2010'),
        (115, '2010-04-10', '2010-04-01', 'C 1.4.2010 по 10.4.2010'),
        (116, '2010-04-20', '2010-04-11', 'C 11.4.2010 по 20.4.2010'),
        (117, '2010-04-30', '2010-04-21', 'C 21.4.2010 по 30.4.2010'),
        (118, '2010-05-10', '2010-05-01', 'C 1.5.2010 по 10.5.2010'),
        (119, '2010-05-20', '2010-05-11', 'C 11.5.2010 по 20.5.2010'),
        (120, '2010-05-31', '2010-05-21', 'C 21.5.2010 по 31.5.2010'),
        (121, '2010-06-10', '2010-06-01', 'C 1.6.2010 по 10.6.2010'),
        (122, '2010-06-20', '2010-06-11', 'C 11.6.2010 по 20.6.2010'),
        (123, '2010-06-30', '2010-06-21', 'C 21.6.2010 по 30.6.2010'),
        (124, '2010-07-10', '2010-07-01', 'C 1.7.2010 по 10.7.2010'),
        (125, '2010-07-20', '2010-07-11', 'C 11.7.2010 по 20.7.2010'),
        (126, '2010-07-31', '2010-07-21', 'C 21.7.2010 по 31.7.2010'),
        (127, '2010-08-10', '2010-08-01', 'C 1.8.2010 по 10.8.2010'),
        (128, '2010-08-20', '2010-08-11', 'C 11.8.2010 по 20.8.2010'),
        (129, '2010-08-31', '2010-08-21', 'C 21.8.2010 по 31.8.2010'),
        (130, '2010-09-10', '2010-09-01', 'C 1.9.2010 по 10.9.2010'),
        (131, '2010-09-20', '2010-09-11', 'C 11.9.2010 по 20.9.2010'),
        (132, '2010-09-30', '2010-09-21', 'C 21.9.2010 по 30.9.2010'),
        (133, '2010-10-10', '2010-10-01', 'C 1.10.2010 по 10.10.2010'),
        (134, '2010-10-20', '2010-10-11', 'C 11.10.2010 по 20.10.2010'),
        (135, '2010-10-31', '2010-10-21', 'C 21.10.2010 по 31.10.2010'),
        (136, '2010-11-10', '2010-11-01', 'C 1.11.2010 по 10.11.2010'),
        (137, '2010-11-20', '2010-11-11', 'C 11.11.2010 по 20.11.2010'),
        (138, '2010-11-30', '2010-11-21', 'с 21.11.2010 по 30.11.2010'),
        (139, '2010-12-10', '2010-12-01', 'с 01.12.2010 по 10.12.2010'),
        (140, '2010-12-20', '2010-12-11', 'с 11.12.2010 по 20.12.2010'),
        (141, '2010-12-31', '2010-12-21', 'с 21.12.2010 по 31.12.2010'),
        (142, '2011-01-10', '2011-01-01', 'с 01.1.2011 по 10.1.2011'),
        (143, '2011-01-20', '2011-01-11', 'с 11.1.2011 по 20.1.2011'),
        (144, '2011-01-31', '2011-01-21', 'с 21.1.2011 по 31.1.2011'),
        (145, '2011-02-10', '2011-02-01', 'с 01.2.2011 по 10.2.2011'),
        (146, '2011-02-20', '2011-02-11', 'с 11.2.2011 по 20.2.2011'),
        (147, '2011-02-28', '2011-02-21', 'с 21.2.2011 по 28.2.2011'),
        (148, '2011-03-10', '2011-03-01', 'с 01.3.2011 по 10.3.2011'),
        (149, '2011-03-20', '2011-03-11', 'с 11.3.2011 по 20.3.2011'),
        (150, '2011-03-31', '2011-03-21', 'с 21.3.2011 по 31.3.2011'),
        (151, '2011-04-10', '2011-04-01', 'с 01.4.2011 по 10.4.2011'),
        (152, '2011-04-20', '2011-04-11', 'с 11.4.2011 по 20.4.2011'),
        (153, '2011-04-30', '2011-04-21', 'с 21.4.2011 по 30.4.2011'),
        (154, '2011-05-10', '2011-05-01', 'с 01.5.2011 по 10.5.2011'),
        (155, '2011-05-20', '2011-05-11', 'с 11.5.2011 по 20.5.2011'),
        (156, '2011-05-31', '2011-05-21', 'с 21.5.2011 по 31.5.2011'),
        (157, '2011-06-10', '2011-06-01', 'с 01.6.2011 по 10.6.2011'),
        (158, '2011-06-20', '2011-06-11', 'с 11.6.2011 по 20.6.2011'),
        (159, '2011-06-30', '2011-06-21', 'с 21.6.2011 по 30.6.2011'),
        (160, '2011-07-10', '2011-07-01', 'с 01.7.2011 по 10.7.2011'),
        (161, '2011-07-20', '2011-07-11', 'с 11.7.2011 по 20.7.2011'),
        (162, '2011-07-31', '2011-07-21', 'с 21.7.2011 по 31.7.2011'),
        (163, '2011-08-10', '2011-08-01', 'с 01.8.2011 по 10.8.2011'),
        (164, '2011-08-20', '2011-08-11', 'с 11.8.2011 по 20.8.2011'),
        (165, '2011-08-31', '2011-08-21', 'с 21.8.2011 по 31.8.2011'),
        (166, '2011-09-10', '2011-09-01', 'с 01.9.2011 по 10.9.2011'),
        (167, '2011-09-20', '2011-09-11', 'с 11.9.2011 по 20.9.2011'),
        (168, '2011-09-30', '2011-09-21', 'с 21.9.2011 по 30.9.2011'),
        (169, '2011-10-10', '2011-10-01', 'с 01.10.2011 по 10.10.2011'),
        (170, '2011-10-20', '2011-10-11', 'с 11.10.2011 по 20.10.2011'),
        (171, '2011-10-31', '2011-10-21', 'с 21.10.2011 по 31.10.2011'),
        (172, '2011-11-10', '2011-11-01', 'с 01.11.2011 по 10.11.2011'),
        (173, '2011-11-20', '2011-11-11', 'с 11.11.2011 по 20.11.2011'),
        (174, '2011-11-30', '2011-11-21', 'с 21.11.2011 по 30.11.2011'),
        (175, '2011-12-10', '2011-12-01', 'с 01.12.2011 по 10.12.2011'),
        (176, '2011-12-20', '2011-12-11', 'с 11.12.2011 по 20.12.2011'),
        (177, '2011-12-31', '2011-12-21', 'с 21.12.2011 по 31.12.2011'),
        (178, '2012-01-10', '2012-01-01', 'с 01.1.2012 по 10.1.2012'),
        (179, '2012-01-20', '2012-01-11', 'с 11.1.2012 по 20.1.2012'),
        (180, '2012-01-31', '2012-01-21', 'с 21.1.2012 по 31.1.2012'),
        (181, '2012-02-10', '2012-02-01', 'с 01.2.2012 по 10.2.2012'),
        (182, '2012-02-20', '2012-02-11', 'с 11.2.2012 по 20.2.2012'),
        (183, '2012-02-29', '2012-02-21', 'с 21.2.2012 по 29.2.2012'),
        (4755, '2012-03-10', '2012-03-01', 'с 01.3.2012 по 10.3.2012'),
        (4756, '2012-03-20', '2012-03-11', 'с 11.3.2012 по 20.3.2012'),
        (4757, '2012-03-31', '2012-03-21', 'с 21.3.2012 по 31.3.2012'),
        (4758, '2012-04-10', '2012-04-01', 'с 01.4.2012 по 10.4.2012'),
        (4759, '2012-04-20', '2012-04-11', 'с 11.4.2012 по 20.4.2012'),
        (4760, '2012-04-30', '2012-04-21', 'с 21.4.2012 по 30.4.2012'),
        (4761, '2012-05-10', '2012-05-01', 'с 01.5.2012 по 10.5.2012'),
        (4762, '2012-05-20', '2012-05-11', 'с 11.5.2012 по 20.5.2012'),
        (4763, '2012-05-31', '2012-05-21', 'с 21.5.2012 по 31.5.2012'),
        (4764, '2012-06-10', '2012-06-01', 'с 01.6.2012 по 10.6.2012'),
        (4765, '2012-06-20', '2012-06-11', 'с 11.6.2012 по 20.6.2012'),
        (4766, '2012-06-30', '2012-06-21', 'с 21.6.2012 по 30.6.2012'),
        (4767, '2012-07-10', '2012-07-01', 'с 01.7.2012 по 10.7.2012'),
        (4768, '2012-07-20', '2012-07-11', 'с 11.7.2012 по 20.7.2012'),
        (4769, '2012-07-31', '2012-07-21', 'с 21.7.2012 по 31.7.2012'),
        (4770, '2012-08-10', '2012-08-01', 'с 01.8.2012 по 10.8.2012'),
        (4771, '2012-08-20', '2012-08-11', 'с 11.8.2012 по 20.8.2012'),
        (4772, '2012-08-31', '2012-08-21', 'с 21.8.2012 по 31.8.2012'),
        (4773, '2012-09-10', '2012-09-01', 'с 01.9.2012 по 10.9.2012'),
        (4774, '2012-09-20', '2012-09-11', 'с 11.9.2012 по 20.9.2012'),
        (4775, '2012-09-30', '2012-09-21', 'с 21.9.2012 по 30.9.2012'),
        (4776, '2012-10-10', '2012-10-01', 'с 01.10.2012 по 10.10.2012'),
        (4777, '2012-10-20', '2012-10-11', 'с 11.10.2012 по 20.10.2012'),
        (4778, '2012-10-31', '2012-10-21', 'с 21.10.2012 по 31.10.2012'),
        (4779, '2012-11-10', '2012-11-01', 'с 01.11.2012 по 10.11.2012'),
        (4780, '2012-11-20', '2012-11-11', 'с 11.11.2012 по 20.11.2012'),
        (4781, '2012-11-30', '2012-11-21', 'с 21.11.2012 по 30.11.2012'),
        (4782, '2012-12-10', '2012-12-01', 'с 01.12.2012 по 10.12.2012'),
        (4783, '2012-12-20', '2012-12-11', 'с 11.12.2012 по 20.12.2012'),
        (4784, '2012-12-31', '2012-12-21', 'с 21.12.2012 по 31.12.2012'),
        (4785, '2013-01-10', '2013-01-01', 'с 01.1.2013 по 10.1.2013'),
        (4786, '2013-01-20', '2013-01-11', 'с 11.1.2013 по 20.1.2013'),
        (4787, '2013-01-31', '2013-01-21', 'с 21.1.2013 по 31.1.2013'),
        (4788, '2013-02-10', '2013-02-01', 'с 01.2.2013 по 10.2.2013'),
        (4789, '2013-02-20', '2013-02-11', 'с 11.2.2013 по 20.2.2013'),
        (4790, '2013-02-28', '2013-02-21', 'с 21.2.2013 по 28.2.2013'),
        (4791, '2013-03-10', '2013-03-01', 'с 01.3.2013 по 10.3.2013'),
        (4792, '2013-03-20', '2013-03-11', 'с 11.3.2013 по 20.3.2013');
      END;
    END IF;

  END $$
DELIMITER ;

call setup_script();