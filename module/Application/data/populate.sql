/*
 *	Roles
 */
ALTER TABLE roombooking.Roles AUTO_INCREMENT=1;
INSERT INTO roombooking.Roles (rolename) VALUES ('Administrator'), ('Custodian'), ('User'), ('Guest');

/*
 *	Admin Powers
 */
INSERT INTO roombooking.Powers (powerid, roleid, module, controller, action) VALUES (1, 1, '%', '%', '%');
 