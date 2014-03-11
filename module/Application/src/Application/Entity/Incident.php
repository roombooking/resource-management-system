<?php
namespace Application\Entity;

class Incident {
    //     SELECT
    //          Incidents.incidentid AS incidentid,
    //          Incidents.userid AS userid,
    //          Incidents.bookingid AS bookingid,
    //          Incidents.resourceid AS resourceid,
    //          Incidents.class AS class,
    //          Incidents.description AS description,
    //          Incidents.time AS time
    //     FROM
    //          Incidents
    
    protected $incidentid;
    protected $userid;
    protected $bookingid;
    protected $resourceid;
    protected $class;
    protected $description;
    protected $time;
    
    /**
    * Sets incidentid
    *
    * @param type $incidentid
    * @return void
    */
    public function setincidentid($incidentid)
    {
            $this->incidentid = $incidentid;
    }
    
    /**
    * Gets incidentid
    *
    * @return type
    */
    public function getincidentid()
    {
            return $this->incidentid;
    }
    
    /**
    * Sets userid
    *
    * @param type $userid
    * @return void
    */
    public function setuserid($userid)
    {
            $this->userid = $userid;
    }
    
    /**
    * Gets userid
    *
    * @return type
    */
    public function getuserid()
    {
            return $this->userid;
    }
    
    /**
    * Sets bookingid
    *
    * @param type $bookingid
    * @return void
    */
    public function setbookingid($bookingid)
    {
            $this->bookingid = $bookingid;
    }
    
    /**
    * Gets bookingid
    *
    * @return type
    */
    public function getbookingid()
    {
            return $this->bookingid;
    }
    
    /**
    * Sets resourceid
    *
    * @param type $resourceid
    * @return void
    */
    public function setresourceid($resourceid)
    {
            $this->resourceid = $resourceid;
    }
    
    /**
    * Gets resourceid
    *
    * @return type
    */
    public function getresourceid()
    {
            return $this->resourceid;
    }
    
    /**
    * Sets class
    *
    * @param type $class
    * @return void
    */
    public function setclass($class)
    {
            $this->class = $class;
    }
    
    /**
    * Gets class
    *
    * @return type
    */
    public function getclass()
    {
            return $this->class;
    }
    
    /**
    * Sets description
    *
    * @param type $description
    * @return void
    */
    public function setdescription($description)
    {
            $this->description = $description;
    }
    
    /**
    * Gets description
    *
    * @return type
    */
    public function getdescription()
    {
            return $this->description;
    }
    
    /**
    * Sets time
    *
    * @param type $time
    * @return void
    */
    public function settime($time)
    {
            $this->time = $time;
    }
    
    /**
    * Gets time
    *
    * @return type
    */
    public function gettime()
    {
            return $this->time;
    }
}
?>