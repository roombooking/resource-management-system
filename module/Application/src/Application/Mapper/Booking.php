<?php
namespace Application\Mapper;

use Application\Entity\Booking as BookingEntity;
use Zend\Db\ResultSet\HydratingResultSet;

class Booking
{   
    /**
     * Constructor
     * 
     * @param AdapterInterface $adapter
     */
    public function __construct($adapter)
    {
        $this->entityPrototype = new BookingEntity();
        $this->hydrator = new \Zend\Stdlib\Hydrator\Reflection;
        $this->adapter = $adapter;
    }

    public function fetchBookings ($start, $end)
    {
        $statement = $this->adapter->createStatement();
        $statement->prepare("SELECT Users.firstname AS firstname, Users.lastname AS lastname, Users.emailaddress AS emailaddress, Bookings.name AS bookingname, Bookings.description AS bookingdescription, DATE_FORMAT(Bookings.start, '%Y-%m-%dT%TZ') AS bookingstart, DATE_FORMAT(Bookings.end, '%Y-%m-%dT%TZ') AS bookingend, Bookings.isprebooking AS isprebooking, Resources.name AS resourcename, Resources.description AS resourcedescription FROM Users RIGHT OUTER JOIN Bookings ON Users.userid = Bookings.booking_userid LEFT OUTER JOIN Resources ON Bookings.resourceid = Resources.resourceid WHERE ( (UNIX_TIMESTAMP(Bookings.start) >= " . $start . " AND UNIX_TIMESTAMP(Bookings.start) <= " . $end . ") OR (UNIX_TIMESTAMP(Bookings.end) >= " . $start . " AND UNIX_TIMESTAMP(Bookings.end) <= " . $end . ") ) AND Bookings.isdeleted = false;");
        
        $result = $statement->execute();
        
        $resultSet = new HydratingResultSet($this->hydrator, $this->entityPrototype);
        
        return $resultSet->initialize($result);
    }
}
?>