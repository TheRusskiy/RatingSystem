CREATE TABLE testings(
  id NUMERIC(6,0) NOT NULL AUTO_INCREMENT,
  time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(id)
);
INSERT into testings VALUES();

DROP TABLE STAFF;
CREATE TABLE staff(
  id NUMERIC(6,0) NOT NULL AUTO_INCREMENT,
  name VARCHAR (30),
  PRIMARY KEY(id)
);
