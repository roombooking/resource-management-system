/*
Created: 06/12/2013
Modified: 06/12/2013
Model: MySQL 5.1
Database: MySQL 5.1
*/

-- Create tables section -------------------------------------------------

-- Table Users

CREATE TABLE Users
(
  userid Text NOT NULL
  COMMENT 'The users LDAP userid / uid',
  roleid Int NOT NULL,
  role Int NOT NULL DEFAULT 0
  COMMENT 'The role of the user according to the Roles table'
)
;

ALTER TABLE Users ADD PRIMARY KEY (userid,roleid)
;

-- Table Roles

CREATE TABLE Roles
(
  roleid Int NOT NULL,
  rolename Varchar(120)
)
;

ALTER TABLE Roles ADD PRIMARY KEY (roleid)
;

-- Table Powers

CREATE TABLE Powers
(
  roleid Int NOT NULL,
  show_calendar Bool DEFAULT FALSE,
  show_appointment_details Bool DEFAULT FALSE,
  export_appointment Bool DEFAULT FALSE,
  show_room_list Bool DEFAULT FALSE,
  show_room_details Bool DEFAULT FALSE,
  show_equipment_list Bool DEFAULT FALSE,
  show_equipment_details Bool DEFAULT FALSE,
  show_user_details Bool DEFAULT FALSE,
  edit_user_roles Bool DEFAULT FALSE,
  add_appointment Bool DEFAULT FALSE,
  edit_own_appointment Bool DEFAULT FALSE,
  delete_own_appointment Bool DEFAULT FALSE,
  delete_foreign_appointment Bool DEFAULT FALSE,
  edit_foreign_appointment Bool DEFAULT FALSE,
  generate_appointment_suggestion Bool DEFAULT FALSE,
  add_prebooking Bool DEFAULT FALSE,
  edit_own_prebooking Bool DEFAULT FALSE,
  delete_own_prebooking Bool DEFAULT FALSE,
  delete_foreign_prebooking Bool DEFAULT FALSE,
  edit_foreign_prebooking Bool DEFAULT FALSE,
  edit_room_description Bool DEFAULT FALSE,
  add_room Bool DEFAULT FALSE,
  delete_room Bool DEFAULT FALSE,
  add_equipment Bool DEFAULT FALSE,
  edit_equipment_description Bool DEFAULT FALSE,
  delete_equipment Bool DEFAULT FALSE
)
;

ALTER TABLE Powers ADD PRIMARY KEY (roleid)
;

-- Table Rooms

CREATE TABLE Rooms
(
  roomid Int NOT NULL AUTO_INCREMENT,
  containmentid Int NOT NULL,
  description Varchar(120) NOT NULL,
 PRIMARY KEY (roomid,containmentid)
)
;

-- Table Roomcontainments

CREATE TABLE Roomcontainments
(
  containmentid Int NOT NULL,
  parent Int,
  title Varchar(120) NOT NULL,
  description Text
)
  COMMENT = 'http://stackoverflow.com/questions/2175882/how-to-represent-a-data-tree-in-sql#answer-2175926'
;

ALTER TABLE Roomcontainments ADD PRIMARY KEY (containmentid)
;

-- Table Roombookings

CREATE TABLE Roombookings
(
  bookingid Int NOT NULL AUTO_INCREMENT,
  is_prebooking Bool DEFAULT FALSE,
  userid_booking Text NOT NULL,
  userid_responsible Text,
  roleid_booking Int NOT NULL,
  roomid Int NOT NULL,
  containmentid Int NOT NULL,
  booking_from Datetime NOT NULL,
  booking_to Datetime NOT NULL
)
;

ALTER TABLE Roombookings ADD PRIMARY KEY (userid_booking,roleid_booking,roomid,containmentid,bookingid)
;

-- Table Equipments

CREATE TABLE Equipments
(
  equipmentid Int NOT NULL AUTO_INCREMENT,
  containmentid Int NOT NULL,
  description Varchar(120),
 PRIMARY KEY (equipmentid,containmentid)
)
;

-- Table Equipmentcontainments

CREATE TABLE Equipmentcontainments
(
  containmentid Int NOT NULL,
  parent Int,
  title Varchar(120) NOT NULL DEFAULT title,
  description Text
)
;

ALTER TABLE Equipmentcontainments ADD PRIMARY KEY (containmentid)
;

-- Table Equipmentbookings

CREATE TABLE Equipmentbookings
(
  userid Text NOT NULL,
  roleid Int NOT NULL,
  equipmentid Int NOT NULL,
  equipment_containmentid Int NOT NULL,
  roomid Int,
  room_containmentid Int,
  booking_from Datetime NOT NULL,
  booking_to Datetime NOT NULL
)
;

ALTER TABLE Equipmentbookings ADD PRIMARY KEY (userid,roleid,equipmentid,equipment_containmentid)
;

-- Table Roomattributes

CREATE TABLE Roomattributes
(
  roomid Int NOT NULL,
  containmentid Int NOT NULL
)
;

ALTER TABLE Roomattributes ADD PRIMARY KEY (roomid,containmentid)
;

-- Table Equipmentattributes

CREATE TABLE Equipmentattributes
(
  equipmentid Int NOT NULL,
  containmentid Int NOT NULL
)
;

ALTER TABLE Equipmentattributes ADD PRIMARY KEY (equipmentid,containmentid)
;

-- Create relationships section ------------------------------------------------- 

ALTER TABLE Rooms ADD CONSTRAINT is_contained_in_1 FOREIGN KEY (containmentid) REFERENCES Roomcontainments (containmentid) ON DELETE NO ACTION ON UPDATE NO ACTION
;

ALTER TABLE Users ADD CONSTRAINT has_role FOREIGN KEY (roleid) REFERENCES Roles (roleid) ON DELETE NO ACTION ON UPDATE NO ACTION
;

ALTER TABLE Powers ADD CONSTRAINT has_powers FOREIGN KEY (roleid) REFERENCES Roles (roleid) ON DELETE NO ACTION ON UPDATE NO ACTION
;

ALTER TABLE Roombookings ADD CONSTRAINT books_room_1 FOREIGN KEY (userid_booking, roleid_booking) REFERENCES Users (userid, roleid) ON DELETE NO ACTION ON UPDATE NO ACTION
;

ALTER TABLE Roombookings ADD CONSTRAINT books_room_2 FOREIGN KEY (roomid, containmentid) REFERENCES Rooms (roomid, containmentid) ON DELETE NO ACTION ON UPDATE NO ACTION
;

ALTER TABLE Equipments ADD CONSTRAINT is_contained_in_2 FOREIGN KEY (containmentid) REFERENCES Equipmentcontainments (containmentid) ON DELETE NO ACTION ON UPDATE NO ACTION
;

ALTER TABLE Equipmentbookings ADD CONSTRAINT books_equipment_1 FOREIGN KEY (userid, roleid) REFERENCES Users (userid, roleid) ON DELETE NO ACTION ON UPDATE NO ACTION
;

ALTER TABLE Equipmentbookings ADD CONSTRAINT books_equipment_2 FOREIGN KEY (equipmentid, equipment_containmentid) REFERENCES Equipments (equipmentid, containmentid) ON DELETE NO ACTION ON UPDATE NO ACTION
;

ALTER TABLE Equipmentbookings ADD CONSTRAINT belongs_to FOREIGN KEY (roomid, room_containmentid) REFERENCES Rooms (roomid, containmentid) ON DELETE NO ACTION ON UPDATE NO ACTION
;

ALTER TABLE Roomattributes ADD CONSTRAINT has_1 FOREIGN KEY (roomid, containmentid) REFERENCES Rooms (roomid, containmentid) ON DELETE NO ACTION ON UPDATE NO ACTION
;

ALTER TABLE Equipmentattributes ADD CONSTRAINT has_2 FOREIGN KEY (equipmentid, containmentid) REFERENCES Equipments (equipmentid, containmentid) ON DELETE NO ACTION ON UPDATE NO ACTION
;

