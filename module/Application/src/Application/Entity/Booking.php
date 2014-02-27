<?php
namespace Application\Entity;

class Booking {
    /*
     * SELECT
     *      Users.firstname AS firstname,
     *      Users.lastname AS lastname,
     *      Users.emailaddress AS emailaddress,
     *      Bookings.name AS bookingname,
     *      Bookings.description AS bookingdescription,
     *      Bookings.start AS bookingstart,
     *      Bookings.end AS bookingend,
     *      Bookings.isprebooking AS isprebooking,
     *      Resources.name AS resourcename,
     *      Resources.description AS resourcedescription 
     * FROM
     *      Users RIGHT OUTER JOIN Bookings ON Users.userid = Bookings.booking_userid
     *      LEFT OUTER JOIN Resources ON Bookings.resourceid = Resources.resourceid
     * WHERE
     * 	(
     *      (UNIX_TIMESTAMP(Bookings.start) >= 1390777200 AND UNIX_TIMESTAMP(Bookings.start) <= 1394406000)
     *  OR
     *      (UNIX_TIMESTAMP(Bookings.end) >= 1390777200 AND UNIX_TIMESTAMP(Bookings.end) <= 1394406000)
     *  )
     *  AND
     *      Bookings.isdeleted = false;
     */
    
    protected $firstname;
    protected $lastname;
    protected $emailaddress;
    protected $bookingname;
    protected $bookingdescription;
    protected $bookingstart;
    protected $bookingend;
    protected $isprebooking;
    protected $resourcename;
    protected $resourcedescription;
    
    /**
    * Legt firstname fest
    *
    * @param type $firstname
    * @return void
    */
    public function setFirstname($firstname)
    {
            $this->firstname = $firstname;
    }
    
    /**
    * Gibt firstname zurück
    *
    * @return type
    */
    public function getFirstname()
    {
            return $this->firstname;
    }
    
    /**
    * Legt lastname fest
    *
    * @param type $lastname
    * @return void
    */
    public function setLastname($lastname)
    {
            $this->lastname = $lastname;
    }
    
    /**
    * Gibt lastname zurück
    *
    * @return type
    */
    public function getLastname()
    {
            return $this->lastname;
    }
    
    /**
    * Legt emailaddress fest
    *
    * @param type $emailaddress
    * @return void
    */
    public function setEmailaddress($emailaddress)
    {
            $this->emailaddress = $emailaddress;
    }
    
    /**
    * Gibt emailaddress zurück
    *
    * @return type
    */
    public function getEmailaddress()
    {
            return $this->emailaddress;
    }
    
    /**
    * Legt bookingname fest
    *
    * @param type $bookingname
    * @return void
    */
    public function setBookingname($bookingname)
    {
            $this->bookingname = $bookingname;
    }
    
    /**
    * Gibt bookingname zurück
    *
    * @return type
    */
    public function getBookingname()
    {
            return $this->bookingname;
    }
    
    /**
    * Legt bookingdescription fest
    *
    * @param type $bookingdescription
    * @return void
    */
    public function setBookingdescription($bookingdescription)
    {
            $this->bookingdescription = $bookingdescription;
    }
    
    /**
    * Gibt bookingdescription zurück
    *
    * @return type
    */
    public function getBookingdescription()
    {
            return $this->bookingdescription;
    }
    
    /**
    * Legt bookingstart fest
    *
    * @param type $bookingstart
    * @return void
    */
    public function setBookingstart($bookingstart)
    {
            $this->bookingstart = $bookingstart;
    }
    
    /**
    * Gibt bookingstart zurück.
    * 
    * Uses the International Standard for the representation of dates and times, ISO 8601.
    *
    * @return type
    */
    public function getBookingstart()
    {
            return $this->bookingstart;
    }
    
    /**
    * Legt bookingend fest
    *
    * @param type $bookingend
    * @return void
    */
    public function setBookingend($bookingend)
    {
            $this->bookingend = $bookingend;
    }
    
    /**
    * Gibt bookingend zurück
    *
    * Uses the International Standard for the representation of dates and times, ISO 8601.
    *
    * @return type
    */
    public function getBookingend()
    {
            return $this->bookingend;
    }
    
    /**
    * Legt isprebooking fest
    *
    * @param type $isprebooking
    * @return void
    */
    public function setIsprebooking($isprebooking)
    {
            $this->isprebooking = $isprebooking;
    }
    
    /**
    * Gibt isprebooking zurück
    *
    * @return type
    */
    public function getIsprebooking()
    {
            return $this->isprebooking;
    }
    
    /**
    * Legt resourcename fest
    *
    * @param type $resourcename
    * @return void
    */
    public function setResourcename($resourcename)
    {
            $this->resourcename = $resourcename;
    }
    
    /**
    * Gibt resourcename zurück
    *
    * @return type
    */
    public function getResourcename()
    {
            return $this->resourcename;
    }
    
    /**
    * Legt resourcedescription fest
    *
    * @param type $resourcedescription
    * @return void
    */
    public function setResourcedescription($resourcedescription)
    {
            $this->resourcedescription = $resourcedescription;
    }
    
    /**
    * Gibt resourcedescription zurück
    *
    * @return type
    */
    public function getResourcedescription()
    {
            return $this->resourcedescription;
    }
}
?>