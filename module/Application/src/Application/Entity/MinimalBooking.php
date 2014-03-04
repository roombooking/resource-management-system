<?php
namespace Application\Entity;

class MinimalBooking {
    //             SELECT
    //                  b.bookingid AS b_bookingid,
    //                  b.name AS b_name,
    //                  b.start AS b_start,
    //                  b.end AS b_end,
    //                  b.isprebooking AS b_isprebooking,
    //                  b.resourceid AS b_resourceid,
    //                  r.color AS r_color
    //             FROM
    //                  Resources r RIGHT OUTER JOIN Bookings b ON r.resourceid = b.resourceid
    
    protected $b_bookingid;
    protected $b_name;
    protected $b_start;
    protected $b_end;
    protected $b_isprebooking;
    protected $b_resourceid;
    protected $r_color;
    
    /**
    * Sets b_bookingid
    *
    * @param type $b_bookingid
    * @return void
    */
    public function setb_bookingid($b_bookingid)
    {
            $this->b_bookingid = $b_bookingid;
    }
    
    /**
    * Gets b_bookingid
    *
    * @return type
    */
    public function getb_bookingid()
    {
            return $this->b_bookingid;
    }
    
    /**
    * Sets b_name
    *
    * @param type $b_name
    * @return void
    */
    public function setb_name($b_name)
    {
            $this->b_name = $b_name;
    }
    
    /**
    * Gets b_name
    *
    * @return type
    */
    public function getb_name()
    {
            return $this->b_name;
    }
    
    /**
    * Sets b_start
    *
    * @param type $b_start
    * @return void
    */
    public function setb_start($b_start)
    {
            $this->b_start = $b_start;
    }
    
    /**
    * Gets b_start
    *
    * @return type
    */
    public function getb_start()
    {
            return $this->b_start;
    }
    
    /**
    * Sets b_end
    *
    * @param type $b_end
    * @return void
    */
    public function setb_end($b_end)
    {
            $this->b_end = $b_end;
    }
    
    /**
    * Gets b_end
    *
    * @return type
    */
    public function getb_end()
    {
            return $this->b_end;
    }
    
    /**
    * Sets b_isprebooking
    *
    * @param type $b_isprebooking
    * @return void
    */
    public function setb_isprebooking($b_isprebooking)
    {
            $this->b_isprebooking = $b_isprebooking;
    }
    
    /**
    * Gets b_isprebooking
    *
    * @return type
    */
    public function getb_isprebooking()
    {
            return $this->b_isprebooking;
    }
    
    /**
    * Sets b_resourceid
    *
    * @param type $b_resourceid
    * @return void
    */
    public function setb_resourceid($b_resourceid)
    {
            $this->b_resourceid = $b_resourceid;
    }
    
    /**
    * Gets b_resourceid
    *
    * @return type
    */
    public function getb_resourceid()
    {
            return $this->b_resourceid;
    }
    
    /**
    * Sets r_color
    *
    * @param type $r_color
    * @return void
    */
    public function setr_color($r_color)
    {
            $this->r_color = $r_color;
    }
    
    /**
    * Gets r_color
    *
    * @return type
    */
    public function getr_color()
    {
            return $this->r_color;
    }
}
?>