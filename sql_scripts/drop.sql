/*
Created: 06/12/2013
Modified: 14/12/2013
Model: MySQL 5.1
Database: MySQL 5.1
*/


-- Drop relationships section -------------------------------------------------

ALTER TABLE Equipmentbookings DROP FOREIGN KEY contains_2
;
ALTER TABLE Equipmentbookings DROP FOREIGN KEY contains_1
;
ALTER TABLE Equipments DROP FOREIGN KEY contains_3
;
ALTER TABLE Users DROP FOREIGN KEY has_4
;
ALTER TABLE Equipmentattributes DROP FOREIGN KEY has_2
;
ALTER TABLE Roomattributes DROP FOREIGN KEY has_1
;
ALTER TABLE Equipments DROP FOREIGN KEY is_contained_in_2
;
ALTER TABLE Roombookings DROP FOREIGN KEY books_room_2
;
ALTER TABLE Roombookings DROP FOREIGN KEY books_room_1
;
ALTER TABLE Powers DROP FOREIGN KEY has_3
;
ALTER TABLE Rooms DROP FOREIGN KEY is_contained_in_1
;




-- Drop keys for tables section -------------------------------------------------

ALTER TABLE Equipmentbookings DROP PRIMARY KEY
;
ALTER TABLE Equipmentattributes DROP PRIMARY KEY
;
ALTER TABLE Roomattributes DROP PRIMARY KEY
;
ALTER TABLE Equipmentcontainments DROP PRIMARY KEY
;
-- ALTER TABLE Equipments DROP PRIMARY KEY
-- ALTER TABLE Roombookings DROP PRIMARY KEY
ALTER TABLE Roomcontainments DROP PRIMARY KEY
;
-- ALTER TABLE Rooms DROP PRIMARY KEY
ALTER TABLE Powers DROP PRIMARY KEY
;
ALTER TABLE Roles DROP PRIMARY KEY
;
ALTER TABLE Users DROP PRIMARY KEY
;



-- Drop tables section ---------------------------------------------------

DROP TABLE Equipmentbookings
;
DROP TABLE Equipmentattributes
;
DROP TABLE Roomattributes
;
DROP TABLE Equipmentcontainments
;
DROP TABLE Equipments
;
DROP TABLE Roombookings
;
DROP TABLE Roomcontainments
;
DROP TABLE Rooms
;
DROP TABLE Powers
;
DROP TABLE Roles
;
DROP TABLE Users
;

