/*
Created: 06/12/2013
Modified: 14/12/2013
Model: MySQL 5.1
Database: MySQL 5.1
*/

-- Create tables section -------------------------------------------------

-- Table Users

CREATE TABLE Users
(
  userid Varchar(767) NOT NULL
  COMMENT 'The users LDAP userid / uid. Accepts uids up to 767 chars only.',
  roleid Int,
  role Int NOT NULL DEFAULT 0
  COMMENT 'The role of the user according to the Roles table'
)
;

ALTER TABLE Users ADD PRIMARY KEY (userid)
;

-- Table Roles

CREATE TABLE Roles
(
  roleid Int NOT NULL,
  rolename Varchar(767)
)
;

ALTER TABLE Roles ADD PRIMARY KEY (roleid)
;

-- Table Powers

CREATE TABLE Powers
(
  roleid Int NOT NULL,
  show_calendar Bool DEFAULT FALSE
  COMMENT 'Whether the user is allowed to show the calendar',
  show_appointment_details Bool DEFAULT FALSE
  COMMENT 'Whether the user is allowed to show appointment details',
  export_appointment Bool DEFAULT FALSE
  COMMENT 'Whether the user is allowed to export appointments as ICS file',
  show_room_list Bool DEFAULT FALSE
  COMMENT 'Whether the user is allowed to show the room list',
  show_room_details Bool DEFAULT FALSE
  COMMENT 'Whether the user is allowed to show room details',
  show_equipment_list Bool DEFAULT FALSE
  COMMENT 'Whether the user is allowed to show the equipment list',
  show_equipment_details Bool DEFAULT FALSE
  COMMENT 'Whether the user is allowed to show equipment details',
  show_user_details Bool DEFAULT FALSE
  COMMENT 'Whether the user is allowed to show user details',
  edit_user_roles Bool DEFAULT FALSE
  COMMENT 'Whether the user is allowed to edit user roles',
  add_appointment Bool DEFAULT FALSE
  COMMENT 'Whether the user is allowed to add appointments',
  edit_own_appointment Bool DEFAULT FALSE
  COMMENT 'Whether the user is allowed to edit her/his own appointments',
  delete_own_appointment Bool DEFAULT FALSE
  COMMENT 'Whether the user is allowed to delete her/his own appointments',
  delete_foreign_appointment Bool DEFAULT FALSE
  COMMENT 'Whether the user is allowed to delete other users appointments',
  edit_foreign_appointment Bool DEFAULT FALSE
  COMMENT 'Whether the user is allowed to edit other users appointments',
  generate_appointment_suggestion Bool DEFAULT FALSE
  COMMENT 'Whether the user is allowed to generate appointment suggestions',
  add_prebooking Bool DEFAULT FALSE
  COMMENT 'Whether the user is allowed to make pre-bookings',
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
 PRIMARY KEY (roomid)
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
;

ALTER TABLE Roomcontainments ADD PRIMARY KEY (containmentid)
;

-- Table Roombookings

CREATE TABLE Roombookings
(
  bookingid Int NOT NULL AUTO_INCREMENT,
  userid_booking Varchar(767) NOT NULL,
  roomid_booking Int NOT NULL,
  is_prebooking Bool DEFAULT FALSE,
  userid_responsible Text,
  booking_from Datetime NOT NULL,
  booking_to Datetime NOT NULL,
 PRIMARY KEY (bookingid)
)
;

-- Table Equipments

CREATE TABLE Equipments
(
  equipmentid Int NOT NULL AUTO_INCREMENT,
  roomid_equipment Int NOT NULL,
  containmentid Int NOT NULL,
  description Varchar(120),
 PRIMARY KEY (equipmentid)
)
;

-- Table Equipmentcontainments

CREATE TABLE Equipmentcontainments
(
  containmentid Int NOT NULL,
  parent Int,
  title Varchar(120) NOT NULL,
  description Text
)
;

ALTER TABLE Equipmentcontainments ADD PRIMARY KEY (containmentid)
;

-- Table Roomattributes

CREATE TABLE Roomattributes
(
  roomid_attribute Int NOT NULL
)
;

ALTER TABLE Roomattributes ADD PRIMARY KEY (roomid_attribute)
;

-- Table Equipmentattributes

CREATE TABLE Equipmentattributes
(
  equipmentid Int NOT NULL
)
;

ALTER TABLE Equipmentattributes ADD PRIMARY KEY (equipmentid)
;

-- Table Equipmentbookings

CREATE TABLE Equipmentbookings
(
  bookingid Int NOT NULL,
  equipmentid Int NOT NULL
)
;

ALTER TABLE Equipmentbookings ADD PRIMARY KEY (bookingid,equipmentid)
;

-- Create relationships section ------------------------------------------------- 

ALTER TABLE Rooms ADD CONSTRAINT is_contained_in_1 FOREIGN KEY (containmentid) REFERENCES Roomcontainments (containmentid) ON DELETE NO ACTION ON UPDATE NO ACTION
;

ALTER TABLE Powers ADD CONSTRAINT has_3 FOREIGN KEY (roleid) REFERENCES Roles (roleid) ON DELETE CASCADE ON UPDATE NO ACTION
;

ALTER TABLE Roombookings ADD CONSTRAINT books_room_1 FOREIGN KEY (userid_booking) REFERENCES Users (userid) ON DELETE NO ACTION ON UPDATE NO ACTION
;

ALTER TABLE Roombookings ADD CONSTRAINT books_room_2 FOREIGN KEY (roomid_booking) REFERENCES Rooms (roomid) ON DELETE NO ACTION ON UPDATE NO ACTION
;

ALTER TABLE Equipments ADD CONSTRAINT is_contained_in_2 FOREIGN KEY (containmentid) REFERENCES Equipmentcontainments (containmentid) ON DELETE NO ACTION ON UPDATE NO ACTION
;

ALTER TABLE Roomattributes ADD CONSTRAINT has_1 FOREIGN KEY (roomid_attribute) REFERENCES Rooms (roomid) ON DELETE NO ACTION ON UPDATE NO ACTION
;

ALTER TABLE Equipmentattributes ADD CONSTRAINT has_2 FOREIGN KEY (equipmentid) REFERENCES Equipments (equipmentid) ON DELETE NO ACTION ON UPDATE NO ACTION
;

ALTER TABLE Users ADD CONSTRAINT has_4 FOREIGN KEY (roleid) REFERENCES Roles (roleid) ON DELETE RESTRICT ON UPDATE NO ACTION
;

ALTER TABLE Equipments ADD CONSTRAINT contains_3 FOREIGN KEY (roomid_equipment) REFERENCES Rooms (roomid) ON DELETE NO ACTION ON UPDATE NO ACTION
;

ALTER TABLE Equipmentbookings ADD CONSTRAINT contains_1 FOREIGN KEY (bookingid) REFERENCES Roombookings (bookingid) ON DELETE NO ACTION ON UPDATE NO ACTION
;

ALTER TABLE Equipmentbookings ADD CONSTRAINT contains_2 FOREIGN KEY (equipmentid) REFERENCES Equipments (equipmentid) ON DELETE NO ACTION ON UPDATE NO ACTION
;

