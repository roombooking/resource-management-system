To keep databases consistent across all environments, execute
the following scripts in order in your DBMS.

	1. drop.sql		--> Will drop all relevant keys from the database.
	2. schema.sql	--> Will create all relevant keys.
	3. populate.sql	--> Populate the Schemas with dummy data.