/*
Created: 06/12/2013
Modified: 28/02/2014
Model: MySQL 5.1
Database: MySQL 5.1
*/

-- Create tables section -------------------------------------------------

-- Table Users

CREATE TABLE Users
(
  userid Int UNSIGNED NOT NULL AUTO_INCREMENT,
  roleid Int UNSIGNED NOT NULL,
  ldapid Int UNSIGNED NOT NULL,
  loginname Varchar(256) NOT NULL,
  firstname Varchar(256),
  lastname Varchar(256),
  emailaddress Varchar(256)
  COMMENT 'The maximum length of a valid e-mail address is 254 characters.',
 PRIMARY KEY (userid),
 UNIQUE userid (userid)
)
;

ALTER TABLE Users ADD UNIQUE ldapid (ldapid)
;

-- Table Roles

CREATE TABLE Roles
(
  roleid Int UNSIGNED NOT NULL AUTO_INCREMENT,
  rolename Varchar(256),
 PRIMARY KEY (roleid)
)
;

-- Table Powers

CREATE TABLE Powers
(
  powerid Int UNSIGNED NOT NULL AUTO_INCREMENT,
  roleid Int UNSIGNED NOT NULL,
  module Varchar(256) NOT NULL,
  controller Varchar(256) NOT NULL,
  action Varchar(256) NOT NULL,
 PRIMARY KEY (powerid)
)
;

-- Table Bookings

CREATE TABLE Bookings
(
  bookingid Int UNSIGNED NOT NULL AUTO_INCREMENT,
  booking_userid Int UNSIGNED NOT NULL,
  responsible_userid Int UNSIGNED,
  resourceid Int UNSIGNED NOT NULL,
  name Varchar(256),
  description Text,
  participant_description Text,
  start Datetime NOT NULL,
  end Datetime NOT NULL,
  isprebooking Bool NOT NULL DEFAULT 0,
  isdeleted Bool NOT NULL DEFAULT 0,
 PRIMARY KEY (bookingid),
 UNIQUE bookingid (bookingid)
)
;

-- Table Resources

CREATE TABLE Resources
(
  resourceid Int UNSIGNED NOT NULL AUTO_INCREMENT,
  isbookable Bool NOT NULL DEFAULT 0,
  isdeleted Bool NOT NULL DEFAULT 0,
  name Varchar(256),
  description Text,
  color Varchar(32)
  COMMENT 'An HTML color code such as #123456, red or rgb(12, 34, 56), should the default color be overwritten',
 PRIMARY KEY (resourceid)
)
;

-- Table Containments

CREATE TABLE Containments
(
  containmentid Int UNSIGNED NOT NULL AUTO_INCREMENT,
  hirachyid Int UNSIGNED NOT NULL,
  parent Int UNSIGNED,
  child Int UNSIGNED,
  name Varchar(256),
  description Text,
 PRIMARY KEY (containmentid)
)
;

-- Table Hirachies

CREATE TABLE Hirachies
(
  hirachyid Int UNSIGNED NOT NULL
)
;

ALTER TABLE Hirachies ADD PRIMARY KEY (hirachyid)
;

ALTER TABLE Hirachies ADD UNIQUE hirachyid (hirachyid)
;

-- Table Equipments

CREATE TABLE Equipments
(
  equipmentid Int UNSIGNED NOT NULL AUTO_INCREMENT,
  resourceid Int UNSIGNED,
 PRIMARY KEY (equipmentid)
)
;

-- Table Places

CREATE TABLE Places
(
  placeid Int UNSIGNED NOT NULL AUTO_INCREMENT,
  resourceid Int UNSIGNED,
  size Float,
  seatnumber Int,
 PRIMARY KEY (placeid)
)
;

-- Table Bookingrelations

CREATE TABLE Bookingrelations
(
  masterbookingid Int UNSIGNED NOT NULL,
  slavebookingid Int UNSIGNED NOT NULL
)
;

ALTER TABLE Bookingrelations ADD PRIMARY KEY (slavebookingid,masterbookingid)
;

-- Table Incidents

CREATE TABLE Incidents
(
  incidentid Mediumint UNSIGNED NOT NULL AUTO_INCREMENT,
  userid Int UNSIGNED
  COMMENT 'Optional. If a user is affected by the incident.',
  bookingid Int UNSIGNED
  COMMENT 'Optional. If a booking is affected by the incident.',
  resourceid Int UNSIGNED
  COMMENT 'Optional. If a resource is affected by the incident.',
  class Tinyint UNSIGNED NOT NULL DEFAULT 0
  COMMENT '0 = Info, 1 = Warning, 2 = Error, 3 = critical',
  description Text NOT NULL,
  time Timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (incidentid)
)
;

-- Create relationships section ------------------------------------------------- 

ALTER TABLE Powers ADD CONSTRAINT has_1 FOREIGN KEY (roleid) REFERENCES Roles (roleid) ON DELETE CASCADE ON UPDATE NO ACTION
;

ALTER TABLE Users ADD CONSTRAINT has_2 FOREIGN KEY (roleid) REFERENCES Roles (roleid) ON DELETE RESTRICT ON UPDATE NO ACTION
;

ALTER TABLE Bookings ADD CONSTRAINT books_1 FOREIGN KEY (booking_userid) REFERENCES Users (userid) ON DELETE RESTRICT ON UPDATE NO ACTION
;

ALTER TABLE Bookings ADD CONSTRAINT contains_1 FOREIGN KEY (resourceid) REFERENCES Resources (resourceid) ON DELETE RESTRICT ON UPDATE NO ACTION
;

ALTER TABLE Containments ADD CONSTRAINT is_2 FOREIGN KEY (parent) REFERENCES Resources (resourceid) ON DELETE RESTRICT ON UPDATE NO ACTION
;

ALTER TABLE Containments ADD CONSTRAINT is_1 FOREIGN KEY (child) REFERENCES Resources (resourceid) ON DELETE RESTRICT ON UPDATE NO ACTION
;

ALTER TABLE Containments ADD CONSTRAINT contains_2 FOREIGN KEY (hirachyid) REFERENCES Hirachies (hirachyid) ON DELETE RESTRICT ON UPDATE NO ACTION
;

ALTER TABLE Bookings ADD CONSTRAINT books_2 FOREIGN KEY (responsible_userid) REFERENCES Users (userid) ON DELETE RESTRICT ON UPDATE NO ACTION
;

ALTER TABLE Equipments ADD CONSTRAINT extends_1 FOREIGN KEY (resourceid) REFERENCES Resources (resourceid) ON DELETE RESTRICT ON UPDATE NO ACTION
;

ALTER TABLE Places ADD CONSTRAINT extends_2 FOREIGN KEY (resourceid) REFERENCES Resources (resourceid) ON DELETE RESTRICT ON UPDATE NO ACTION
;

ALTER TABLE Bookingrelations ADD CONSTRAINT is_3 FOREIGN KEY (masterbookingid) REFERENCES Bookings (bookingid) ON DELETE RESTRICT ON UPDATE NO ACTION
;

ALTER TABLE Bookingrelations ADD CONSTRAINT is_4 FOREIGN KEY (slavebookingid) REFERENCES Bookings (bookingid) ON DELETE RESTRICT ON UPDATE NO ACTION
;

ALTER TABLE Incidents ADD CONSTRAINT affects_1 FOREIGN KEY (userid) REFERENCES Users (userid) ON DELETE SET NULL ON UPDATE NO ACTION
;

ALTER TABLE Incidents ADD CONSTRAINT affects_2 FOREIGN KEY (bookingid) REFERENCES Bookings (bookingid) ON DELETE SET NULL ON UPDATE NO ACTION
;

ALTER TABLE Incidents ADD CONSTRAINT affects_3 FOREIGN KEY (resourceid) REFERENCES Resources (resourceid) ON DELETE SET NULL ON UPDATE NO ACTION
;

