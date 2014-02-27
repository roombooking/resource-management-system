SELECT
	Users.firstname  AS firstname, Users.lastname AS lastname, Users.emailaddress AS emailaddress, Bookings.name AS bookingname, Bookings.description AS bookingdescription, Bookings.start AS bookingstart, Bookings.end AS bookingend, Bookings.isprebooking AS isprebooking, Resources.name AS resourcename, Resources.description AS resourcedescription 
FROM
     Users RIGHT OUTER JOIN Bookings ON Users.userid = Bookings.booking_userid
     LEFT OUTER JOIN Resources ON Bookings.resourceid = Resources.resourceid
WHERE
	(
			(UNIX_TIMESTAMP(Bookings.start) >= 1390777200 AND UNIX_TIMESTAMP(Bookings.start) <= 1394406000)
		OR
			(UNIX_TIMESTAMP(Bookings.end) >= 1390777200 AND UNIX_TIMESTAMP(Bookings.end) <= 1394406000)
	)
	AND
		Bookings.isdeleted = false;


