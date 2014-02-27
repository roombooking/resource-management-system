SELECT *
FROM Bookings
WHERE
	(
			(UNIX_TIMESTAMP(start) >= 1390777200 AND UNIX_TIMESTAMP(start) <= 1394406000)
		OR
			(UNIX_TIMESTAMP(end) >= 1390777200 AND UNIX_TIMESTAMP(end) <= 1394406000)
	)
	AND
		isdeleted = false;

