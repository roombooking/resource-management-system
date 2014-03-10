/*
 *	Roles
 */
ALTER TABLE roombooking.Roles AUTO_INCREMENT=1;
INSERT INTO roombooking.Roles (rolename) VALUES ('Administrator'), ('Custodian'), ('User'), ('Guest');

/*
 *	Admin Powers
 */
INSERT INTO roombooking.Powers (powerid, roleid, module, controller, action) VALUES (1, 1, '%', '%', '%');

/*
 *	Fake Users
 */
INSERT INTO `roombooking`.`Users` (`userid`, `roleid`, `ldapid`, `loginname`, `firstname`, `lastname`, `emailaddress`) VALUES (NULL, '1', '1', 'moritzplatt', 'Moritz', 'Platt', 'moritz.platt@campus.tu-berlin.de');
INSERT INTO `roombooking`.`Users` (`userid`, `roleid`, `ldapid`, `loginname`, `firstname`, `lastname`, `emailaddress`) VALUES (NULL, '2', '2', 'JaromirWozniak', 'Jaromir', 'Woźniak', 'JaromirWozniak@superrito.com');
INSERT INTO `roombooking`.`Users` (`userid`, `roleid`, `ldapid`, `loginname`, `firstname`, `lastname`, `emailaddress`) VALUES (NULL, '2', '3', 'TomiyukiMorita', 'Tomiyuki', 'Morita', 'TomiyukiMorita@dayrep.com');
INSERT INTO `roombooking`.`Users` (`userid`, `roleid`, `ldapid`, `loginname`, `firstname`, `lastname`, `emailaddress`) VALUES (NULL, '3', '4', 'SiposUpor', 'Upor', 'Sipos', 'SiposUpor@superrito.com');
INSERT INTO `roombooking`.`Users` (`userid`, `roleid`, `ldapid`, `loginname`, `firstname`, `lastname`, `emailaddress`) VALUES (NULL, '3', '5', 'IsabelleFlierl', 'Isabelle', 'Flierl', 'IsabelleFlierl@dayrep.com');
INSERT INTO `roombooking`.`Users` (`userid`, `roleid`, `ldapid`, `loginname`, `firstname`, `lastname`, `emailaddress`) VALUES (NULL, '3', '6', 'FelixWobbes', 'Félix', 'Wobbes', 'FelixWobbes@armyspy.com');
INSERT INTO `roombooking`.`Users` (`userid`, `roleid`, `ldapid`, `loginname`, `firstname`, `lastname`, `emailaddress`) VALUES (NULL, '3', '7', 'NemanjaWientjes', 'Nemanja', 'Wientjes', 'NemanjaWientjes@rhyta.com');
INSERT INTO `roombooking`.`Users` (`userid`, `roleid`, `ldapid`, `loginname`, `firstname`, `lastname`, `emailaddress`) VALUES (NULL, '3', '8', 'LukeHamilton', 'Luke', 'Hamilton', 'LukeHamilton@gustr.com');
INSERT INTO `roombooking`.`Users` (`userid`, `roleid`, `ldapid`, `loginname`, `firstname`, `lastname`, `emailaddress`) VALUES (NULL, '3', '9', 'MovlidKhadzhiev', 'Movlid', 'Khadzhiev', 'MovlidKhadzhiev@gustr.com');
INSERT INTO `roombooking`.`Users` (`userid`, `roleid`, `ldapid`, `loginname`, `firstname`, `lastname`, `emailaddress`) VALUES (NULL, '3', '10', 'EvgenijCamic', 'Evgenij', 'Čamič', 'EvgenijCamic@superrito.com');

/*
 *	Fake Containments
 */
INSERT INTO `roombooking`.`Resources` (`resourceid`, `isbookable`, `isdeleted`, `name`, `description`) VALUES (NULL, '0', '0', 'TU Berlin Campus Charlottenburg', 'Der Campus Charlottenburg ist einer der größten zusammenhängenden innerstädtischen Universitätsareale Europas. Der Campus beherbergt ein dichtes, lebendiges Netzwerk und Miteinander aus Wissenschaft, Wirtschaft, Kultur und Politik.');
INSERT INTO `roombooking`.`Resources` (`resourceid`, `isbookable`, `isdeleted`, `name`, `description`) VALUES (NULL, '0', '0', 'TEL', 'Das Telefunken-Hochhaus, Ernst-Reuter-Platz Nr. 7, im Berliner Ortsteil Charlottenburg ist ein 80 Meter hohes Bürogebäude, das unter Denkmalschutz steht.');
INSERT INTO `roombooking`.`Resources` (`resourceid`, `isbookable`, `isdeleted`, `name`, `description`) VALUES (NULL, '0', '0', 'TEL EG', 'Erdgeschoss des TEL Gebäudes.');
INSERT INTO `roombooking`.`Resources` (`resourceid`, `isbookable`, `isdeleted`, `name`, `description`) VALUES (NULL, '0', '0', 'TEL 1. OG', '1. Obergeschoss des TEL Gebäudes.');
INSERT INTO `roombooking`.`Resources` (`resourceid`, `isbookable`, `isdeleted`, `name`, `description`) VALUES (NULL, '0', '0', 'TEL 2. OG', '2. Obergeschoss des TEL Gebäudes.');
INSERT INTO `roombooking`.`Resources` (`resourceid`, `isbookable`, `isdeleted`, `name`, `description`) VALUES (NULL, '0', '0', 'TEL 3. OG', '3. Obergeschoss des TEL Gebäudes.');
INSERT INTO `roombooking`.`Resources` (`resourceid`, `isbookable`, `isdeleted`, `name`, `description`) VALUES (NULL, '0', '0', 'TEL 4. OG', '4. Obergeschoss des TEL Gebäudes.');
INSERT INTO `roombooking`.`Resources` (`resourceid`, `isbookable`, `isdeleted`, `name`, `description`) VALUES (NULL, '0', '0', 'TEL 5. OG', '5. Obergeschoss des TEL Gebäudes.');
INSERT INTO `roombooking`.`Resources` (`resourceid`, `isbookable`, `isdeleted`, `name`, `description`) VALUES (NULL, '0', '0', 'TEL 6. OG', '6. Obergeschoss des TEL Gebäudes.');
INSERT INTO `roombooking`.`Resources` (`resourceid`, `isbookable`, `isdeleted`, `name`, `description`) VALUES (NULL, '0', '0', 'TEL 7. OG', '7. Obergeschoss des TEL Gebäudes.');
INSERT INTO `roombooking`.`Resources` (`resourceid`, `isbookable`, `isdeleted`, `name`, `description`) VALUES (NULL, '0', '0', 'TEL 8. OG', '8. Obergeschoss des TEL Gebäudes.');
INSERT INTO `roombooking`.`Resources` (`resourceid`, `isbookable`, `isdeleted`, `name`, `description`) VALUES (NULL, '0', '0', 'TEL 9. OG', '9. Obergeschoss des TEL Gebäudes.');
INSERT INTO `roombooking`.`Resources` (`resourceid`, `isbookable`, `isdeleted`, `name`, `description`) VALUES (NULL, '0', '0', 'TEL 10. OG', '10. Obergeschoss des TEL Gebäudes.');
INSERT INTO `roombooking`.`Resources` (`resourceid`, `isbookable`, `isdeleted`, `name`, `description`) VALUES (NULL, '0', '0', 'TEL 11. OG', '11. Obergeschoss des TEL Gebäudes.');
INSERT INTO `roombooking`.`Resources` (`resourceid`, `isbookable`, `isdeleted`, `name`, `description`) VALUES (NULL, '0', '0', 'TEL 12. OG', '12. Obergeschoss des TEL Gebäudes.');
INSERT INTO `roombooking`.`Resources` (`resourceid`, `isbookable`, `isdeleted`, `name`, `description`) VALUES (NULL, '0', '0', 'TEL 13. OG', '13. Obergeschoss des TEL Gebäudes.');
INSERT INTO `roombooking`.`Resources` (`resourceid`, `isbookable`, `isdeleted`, `name`, `description`) VALUES (NULL, '0', '0', 'TEL 14. OG', '14. Obergeschoss des TEL Gebäudes.');
INSERT INTO `roombooking`.`Resources` (`resourceid`, `isbookable`, `isdeleted`, `name`, `description`) VALUES (NULL, '0', '0', 'TEL 15. OG', '15. Obergeschoss des TEL Gebäudes.');
INSERT INTO `roombooking`.`Resources` (`resourceid`, `isbookable`, `isdeleted`, `name`, `description`) VALUES (NULL, '0', '0', 'TEL 16. OG', '16. Obergeschoss des TEL Gebäudes.');
INSERT INTO `roombooking`.`Resources` (`resourceid`, `isbookable`, `isdeleted`, `name`, `description`) VALUES (NULL, '0', '0', 'TEL 17. OG', '17. Obergeschoss des TEL Gebäudes.');
INSERT INTO `roombooking`.`Resources` (`resourceid`, `isbookable`, `isdeleted`, `name`, `description`) VALUES (NULL, '0', '0', 'TEL 18. OG', '18. Obergeschoss des TEL Gebäudes.');
INSERT INTO `roombooking`.`Resources` (`resourceid`, `isbookable`, `isdeleted`, `name`, `description`) VALUES (NULL, '0', '0', 'TEL 19. OG', '19. Obergeschoss des TEL Gebäudes.');
INSERT INTO `roombooking`.`Resources` (`resourceid`, `isbookable`, `isdeleted`, `name`, `description`) VALUES (NULL, '0', '0', 'TEL 20. OG', '20. Obergeschoss des TEL Gebäudes.');

/*
 *	Fake Räume
 */
INSERT INTO `roombooking`.`Resources` (`resourceid`, `isbookable`, `isdeleted`, `name`, `description`, `color`) VALUES (NULL, '1', '0', 'Beispielraum 3001', NULL, 'royalblue');
INSERT INTO `roombooking`.`Resources` (`resourceid`, `isbookable`, `isdeleted`, `name`, `description`, `color`) VALUES (NULL, '1', '0', 'Beispielraum 3002', NULL, '#fb4');
INSERT INTO `roombooking`.`Resources` (`resourceid`, `isbookable`, `isdeleted`, `name`, `description`, `color`) VALUES (NULL, '1', '0', 'Beispielraum 3003', NULL, 'rgb(248,58,34)');
INSERT INTO `roombooking`.`Resources` (`resourceid`, `isbookable`, `isdeleted`, `name`, `description`, `color`) VALUES (NULL, '1', '0', 'Beispielraum 4001', NULL, 'hsl(286,69,67)');
INSERT INTO `roombooking`.`Resources` (`resourceid`, `isbookable`, `isdeleted`, `name`, `description`, `color`) VALUES (NULL, '1', '0', 'Beispielraum 4002', NULL, '#c2c2c2');
INSERT INTO `roombooking`.`Resources` (`resourceid`, `isbookable`, `isdeleted`, `name`, `description`, `color`) VALUES (NULL, '1', '0', 'Beispielraum 4003', NULL, '#ace');

/*
 *	Fake Raumdetails
 */
INSERT INTO `roombooking`.`Places` (`placeid`, `resourceid`, `size`, `seatnumber`) VALUES (NULL, '24', '25', '15');
INSERT INTO `roombooking`.`Places` (`placeid`, `resourceid`, `size`, `seatnumber`) VALUES (NULL, '25', '30', '15');
INSERT INTO `roombooking`.`Places` (`placeid`, `resourceid`, `size`, `seatnumber`) VALUES (NULL, '26', '10', '5');
INSERT INTO `roombooking`.`Places` (`placeid`, `resourceid`, `size`, `seatnumber`) VALUES (NULL, '27', '100', '30');
INSERT INTO `roombooking`.`Places` (`placeid`, `resourceid`, `size`, `seatnumber`) VALUES (NULL, '28', '25', '12');
INSERT INTO `roombooking`.`Places` (`placeid`, `resourceid`, `size`, `seatnumber`) VALUES (NULL, '29', '20', '8');

/*
 *	Fake Items
 */
INSERT INTO `roombooking`.`Resources` (`resourceid`, `isbookable`, `isdeleted`, `name`, `description`, `color`) VALUES (NULL, '1', '0', 'Senheiser HD 598', 'Höchster Audiogenuss, ohne die Nachbarn zu stören. Mit leistungsstarker Technologie, einem tollen Look und viel Komfort ist dieser Kopfhörer die perfekte Ergänzung für Ihr Home-Entertainment-System.', NULL);
INSERT INTO `roombooking`.`Resources` (`resourceid`, `isbookable`, `isdeleted`, `name`, `description`, `color`) VALUES (NULL, '1', '0', 'Sennehiser e 608', 'Dynamisches Miniatur-Instrumentenmikrofon mit Supernierencharakteristik. Flexibler Schwanenhals mit multifunktionalem Clip für einfache Positionierung. Überträgt hohe Schalldruckpegel verzerrungsfrei. Ideal für Blechbläser, Schlagzeug und Holzbläser.', NULL);
INSERT INTO `roombooking`.`Resources` (`resourceid`, `isbookable`, `isdeleted`, `name`, `description`, `color`) VALUES (NULL, '1', '0', 'Panasonic HC-V210EG-K Camcorder', 'Der weiter entwickelte BSI Sensor mit gesteigerter Lichtempfindlichkeit und 2,25 Megapixel sowie die Bildverarbeitung Crystal Engine PRO liefern rauscharme Aufnahmen mit natürlicher Farbigkeit, auch bei wenig Licht.', NULL);
INSERT INTO `roombooking`.`Resources` (`resourceid`, `isbookable`, `isdeleted`, `name`, `description`, `color`) VALUES (NULL, '1', '0', 'Olympus VN-7600 Diktiergerät', 'Mit den Basic-Modellen können Sie Ihre Gedanken, Eindrücke und Ideen ganz einfach zusammentragen und aufbewahren. Diese handlichen, leichten Voice Recorder sind kleine Helfer, die Sie überall mit hinnehmen können.', NULL);

/*
 *	Fake Itemdetails
 */
INSERT INTO `roombooking`.`Equipments` (`equipmentid`, `resourceid`) VALUES (NULL, '30');
INSERT INTO `roombooking`.`Equipments` (`equipmentid`, `resourceid`) VALUES (NULL, '31');
INSERT INTO `roombooking`.`Equipments` (`equipmentid`, `resourceid`) VALUES (NULL, '32');
INSERT INTO `roombooking`.`Equipments` (`equipmentid`, `resourceid`) VALUES (NULL, '33');

/*
 * Fake hierachie für Containments
 */
INSERT INTO `roombooking`.`Hierachies` (`hierarchyid`, `name`) VALUES ('1', 'Technische Universität Berlin');

/*
 *	Fake Containments
 *
 *	TODO:
 *		- Name/Description aus dem Schema entfernen
 *
 *	'Child' ist der betroffene Knoten, parent der Elternknoten
 */
INSERT INTO `roombooking`.`Containments` (`containmentid`, `hierarchyid`, `parent`, `child`, `name`, `description`) VALUES (NULL, '1', NULL, '1', NULL, NULL);
INSERT INTO `roombooking`.`Containments` (`containmentid`, `hierarchyid`, `parent`, `child`, `name`, `description`) VALUES (NULL, '1', '1', '2', NULL, NULL);
INSERT INTO `roombooking`.`Containments` (`containmentid`, `hierarchyid`, `parent`, `child`, `name`, `description`) VALUES (NULL, '1', '2', '3', NULL, NULL);
INSERT INTO `roombooking`.`Containments` (`containmentid`, `hierarchyid`, `parent`, `child`, `name`, `description`) VALUES (NULL, '1', '2', '4', NULL, NULL);
INSERT INTO `roombooking`.`Containments` (`containmentid`, `hierarchyid`, `parent`, `child`, `name`, `description`) VALUES (NULL, '1', '2', '5', NULL, NULL);
INSERT INTO `roombooking`.`Containments` (`containmentid`, `hierarchyid`, `parent`, `child`, `name`, `description`) VALUES (NULL, '1', '2', '6', NULL, NULL);
INSERT INTO `roombooking`.`Containments` (`containmentid`, `hierarchyid`, `parent`, `child`, `name`, `description`) VALUES (NULL, '1', '2', '7', NULL, NULL);
INSERT INTO `roombooking`.`Containments` (`containmentid`, `hierarchyid`, `parent`, `child`, `name`, `description`) VALUES (NULL, '1', '2', '8', NULL, NULL);
INSERT INTO `roombooking`.`Containments` (`containmentid`, `hierarchyid`, `parent`, `child`, `name`, `description`) VALUES (NULL, '1', '2', '9', NULL, NULL);
INSERT INTO `roombooking`.`Containments` (`containmentid`, `hierarchyid`, `parent`, `child`, `name`, `description`) VALUES (NULL, '1', '2', '10', NULL, NULL);
INSERT INTO `roombooking`.`Containments` (`containmentid`, `hierarchyid`, `parent`, `child`, `name`, `description`) VALUES (NULL, '1', '2', '11', NULL, NULL);
INSERT INTO `roombooking`.`Containments` (`containmentid`, `hierarchyid`, `parent`, `child`, `name`, `description`) VALUES (NULL, '1', '2', '12', NULL, NULL);
INSERT INTO `roombooking`.`Containments` (`containmentid`, `hierarchyid`, `parent`, `child`, `name`, `description`) VALUES (NULL, '1', '2', '13', NULL, NULL);
INSERT INTO `roombooking`.`Containments` (`containmentid`, `hierarchyid`, `parent`, `child`, `name`, `description`) VALUES (NULL, '1', '2', '14', NULL, NULL);
INSERT INTO `roombooking`.`Containments` (`containmentid`, `hierarchyid`, `parent`, `child`, `name`, `description`) VALUES (NULL, '1', '2', '15', NULL, NULL);
INSERT INTO `roombooking`.`Containments` (`containmentid`, `hierarchyid`, `parent`, `child`, `name`, `description`) VALUES (NULL, '1', '2', '16', NULL, NULL);
INSERT INTO `roombooking`.`Containments` (`containmentid`, `hierarchyid`, `parent`, `child`, `name`, `description`) VALUES (NULL, '1', '2', '17', NULL, NULL);
INSERT INTO `roombooking`.`Containments` (`containmentid`, `hierarchyid`, `parent`, `child`, `name`, `description`) VALUES (NULL, '1', '2', '18', NULL, NULL);
INSERT INTO `roombooking`.`Containments` (`containmentid`, `hierarchyid`, `parent`, `child`, `name`, `description`) VALUES (NULL, '1', '2', '19', NULL, NULL);
INSERT INTO `roombooking`.`Containments` (`containmentid`, `hierarchyid`, `parent`, `child`, `name`, `description`) VALUES (NULL, '1', '2', '20', NULL, NULL);
INSERT INTO `roombooking`.`Containments` (`containmentid`, `hierarchyid`, `parent`, `child`, `name`, `description`) VALUES (NULL, '1', '2', '21', NULL, NULL);
INSERT INTO `roombooking`.`Containments` (`containmentid`, `hierarchyid`, `parent`, `child`, `name`, `description`) VALUES (NULL, '1', '2', '22', NULL, NULL);
INSERT INTO `roombooking`.`Containments` (`containmentid`, `hierarchyid`, `parent`, `child`, `name`, `description`) VALUES (NULL, '1', '2', '23', NULL, NULL);
INSERT INTO `roombooking`.`Containments` (`containmentid`, `hierarchyid`, `parent`, `child`, `name`, `description`) VALUES (NULL, '1', '6', '24', NULL, NULL);
INSERT INTO `roombooking`.`Containments` (`containmentid`, `hierarchyid`, `parent`, `child`, `name`, `description`) VALUES (NULL, '1', '6', '25', NULL, NULL);
INSERT INTO `roombooking`.`Containments` (`containmentid`, `hierarchyid`, `parent`, `child`, `name`, `description`) VALUES (NULL, '1', '6', '26', NULL, NULL);
INSERT INTO `roombooking`.`Containments` (`containmentid`, `hierarchyid`, `parent`, `child`, `name`, `description`) VALUES (NULL, '1', '7', '27', NULL, NULL);
INSERT INTO `roombooking`.`Containments` (`containmentid`, `hierarchyid`, `parent`, `child`, `name`, `description`) VALUES (NULL, '1', '7', '28', NULL, NULL);
INSERT INTO `roombooking`.`Containments` (`containmentid`, `hierarchyid`, `parent`, `child`, `name`, `description`) VALUES (NULL, '1', '7', '29', NULL, NULL);
INSERT INTO `roombooking`.`Containments` (`containmentid`, `hierarchyid`, `parent`, `child`, `name`, `description`) VALUES (NULL, '1', '24', '30', NULL, NULL);
INSERT INTO `roombooking`.`Containments` (`containmentid`, `hierarchyid`, `parent`, `child`, `name`, `description`) VALUES (NULL, '1', '24', '31', NULL, NULL);
INSERT INTO `roombooking`.`Containments` (`containmentid`, `hierarchyid`, `parent`, `child`, `name`, `description`) VALUES (NULL, '1', '24', '32', NULL, NULL);
INSERT INTO `roombooking`.`Containments` (`containmentid`, `hierarchyid`, `parent`, `child`, `name`, `description`) VALUES (NULL, '1', '29', '33', NULL, NULL);

/*
 *	Fake Bookings
 */

-- RAUM
INSERT INTO `roombooking`.`Bookings` (`bookingid`, `booking_userid`, `responsible_userid`, `resourceid`, `name`, `description`, `participant_description`, `start`, `end`, `isprebooking`, `isdeleted`) VALUES (NULL, '1', '1', '24', 'Eine Buchung für den Raum 3001', 'Ich möchte ein Experiment durchführen.', 'Es nehmen einige Personen an dem Experiment teil.', '2014-02-28 09:30:00', '2014-02-28 12:30:00', '0', '0');
INSERT INTO `roombooking`.`Bookings` (`bookingid`, `booking_userid`, `responsible_userid`, `resourceid`, `name`, `description`, `participant_description`, `start`, `end`, `isprebooking`, `isdeleted`) VALUES (NULL, '2', '3', '24', 'Eine Buchung für den Raum 3001', 'Ich möchte ein Experiment durchführen.', 'Es nehmen einige Personen an dem Experiment teil.', '2014-03-01 14:00:00', '2014-03-01 16:30:00', '0', '0');
INSERT INTO `roombooking`.`Bookings` (`bookingid`, `booking_userid`, `responsible_userid`, `resourceid`, `name`, `description`, `participant_description`, `start`, `end`, `isprebooking`, `isdeleted`) VALUES (NULL, '5', '1', '24', 'Eine Buchung für den Raum 3001', 'Ich möchte ein Experiment durchführen.', 'Es nehmen einige Personen an dem Experiment teil.', '2014-03-02 10:00:00', '2014-03-02 14:15:00', '0', '0');
INSERT INTO `roombooking`.`Bookings` (`bookingid`, `booking_userid`, `responsible_userid`, `resourceid`, `name`, `description`, `participant_description`, `start`, `end`, `isprebooking`, `isdeleted`) VALUES (NULL, '7', '9', '29', 'Eine Buchung für den Raum 4003', 'Ich möchte ein Experiment durchführen.', 'Es nehmen einige Personen an dem Experiment teil.', '2014-03-15 08:00:00', '2014-03-15 19:30:00', '0', '0');

-- PRE-BOOKING
INSERT INTO `roombooking`.`Bookings` (`bookingid`, `booking_userid`, `responsible_userid`, `resourceid`, `name`, `description`, `participant_description`, `start`, `end`, `isprebooking`, `isdeleted`) VALUES (NULL, '8', NULL, '26', 'Eine Reservierung für einen langen Zeitraum', 'Versuchbeschreibung im Detail.', 'Teilnehmer', '2014-03-23 00:00:00', '2014-03-26 00:00:00', '1', '0');

-- GELOESCHTE BUCHUNG
INSERT INTO `roombooking`.`Bookings` (`bookingid`, `booking_userid`, `responsible_userid`, `resourceid`, `name`, `description`, `participant_description`, `start`, `end`, `isprebooking`, `isdeleted`) VALUES (NULL, '8', '3', '28', 'Eine gelöschte Buchung', 'Diese Buchung wurde bereits gelöscht.', 'Diese Teilnehmer hätte es bei dem gelöschten Termin geben sollen.', '2014-03-12 06:26:00', '2014-03-12 14:24:00', '0', '1');

-- EQUIPMENT BUCHUNGEN
INSERT INTO `roombooking`.`Bookings` (`bookingid`, `booking_userid`, `responsible_userid`, `resourceid`, `name`, `description`, `participant_description`, `start`, `end`, `isprebooking`, `isdeleted`) VALUES (NULL, '3', NULL, '30', 'Buchung eines Kopfhörers', 'Kopfhörerdetailtext', NULL, '2014-03-18 10:00:00', '2014-03-18 17:00:00', '0', '0');
INSERT INTO `roombooking`.`Bookings` (`bookingid`, `booking_userid`, `responsible_userid`, `resourceid`, `name`, `description`, `participant_description`, `start`, `end`, `isprebooking`, `isdeleted`) VALUES (NULL, '6', '2', '31', 'Buchung eines Mikrofons', 'Buchungsbeschreibung für Mikrofonbuchung', NULL, '2014-03-05 12:00:00', '2014-03-05 16:30:00', '0', '0');
INSERT INTO `roombooking`.`Bookings` (`bookingid`, `booking_userid`, `responsible_userid`, `resourceid`, `name`, `description`, `participant_description`, `start`, `end`, `isprebooking`, `isdeleted`) VALUES (NULL, '5', '2', '32', 'Buchung eines Camcorders', 'Buchungstext Camcorder', NULL, '2014-03-13 10:00:00', '2014-03-13 10:20:00', '0', '0');
INSERT INTO `roombooking`.`Bookings` (`bookingid`, `booking_userid`, `responsible_userid`, `resourceid`, `name`, `description`, `participant_description`, `start`, `end`, `isprebooking`, `isdeleted`) VALUES (NULL, '1', NULL, '33', 'Reservierung eines Diktiergeräts', 'Dieses Reservierung geht über Monatsgrenzen hinaus!', NULL, '2014-02-27 00:00:00', '2014-03-04 00:00:00', '1', '0');