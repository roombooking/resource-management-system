SELECT
*
FROM
     Users RIGHT OUTER JOIN Bookings ON Users.userid = Bookings.booking_userid
     LEFT OUTER JOIN Resources ON Bookings.resourceid = Resources.resourceid
     LEFT OUTER JOIN Places ON Resources.resourceid = Places.resourceid
     LEFT OUTER JOIN Equipments ON Resources.resourceid = Equipments.resourceid
WHERE
	(
			(UNIX_TIMESTAMP(Bookings.start) >= 1390777200 AND UNIX_TIMESTAMP(Bookings.start) <= 1394406000)
		OR
			(UNIX_TIMESTAMP(Bookings.end) >= 1390777200 AND UNIX_TIMESTAMP(Bookings.end) <= 1394406000)
	)
	AND
		Bookings.isdeleted = false;

