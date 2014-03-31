<?php
namespace Application\Entity;

/**
 * Incident Entity
 *
 * This entity represents an incident.
 *
 * The naming follows the name of the attributes in the database.
 *
 * @author Roombooking Study Project (see AUTHORS.md)
 *        
 * @version 0.1
 *         
 */
class Incident
{
    // SELECT
    // Incidents.incidentid AS incidentid,
    // Incidents.userid AS userid,
    // Incidents.bookingid AS bookingid,
    // Incidents.resourceid AS resourceid,
    // Incidents.class AS class,
    // Incidents.description AS description,
    // Incidents.time AS time
    // FROM
    // Incidents
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
    public function setIncidentId ($incidentid)
    {
        $this->incidentid = $incidentid;
    }

    /**
     * Gets incidentid
     *
     * @return type
     */
    public function getIncidentId ()
    {
        return $this->incidentid;
    }

    /**
     * Sets userid
     *
     * @param type $userid            
     * @return void
     */
    public function setUserId ($userid)
    {
        $this->userid = $userid;
    }

    /**
     * Gets userid
     *
     * @return type
     */
    public function getUserId ()
    {
        return $this->userid;
    }

    /**
     * Sets bookingid
     *
     * @param type $bookingid            
     * @return void
     */
    public function setBookingId ($bookingid)
    {
        $this->bookingid = $bookingid;
    }

    /**
     * Gets bookingid
     *
     * @return type
     */
    public function getBookingId ()
    {
        return $this->bookingid;
    }

    /**
     * Sets resourceid
     *
     * @param type $resourceid            
     * @return void
     */
    public function setResourceId ($resourceid)
    {
        $this->resourceid = $resourceid;
    }

    /**
     * Gets resourceid
     *
     * @return type
     */
    public function getResourceId ()
    {
        return $this->resourceid;
    }

    /**
     * Sets class
     *
     * @param type $class            
     * @return void
     */
    public function setClass ($class)
    {
        $this->class = $class;
    }

    /**
     * Gets class
     *
     * @return type
     */
    public function getClass ()
    {
        return $this->class;
    }

    /**
     * Sets description
     *
     * @param type $description            
     * @return void
     */
    public function setDescription ($description)
    {
        $this->description = $description;
    }

    /**
     * Gets description
     *
     * @return type
     */
    public function getDescription ()
    {
        return $this->description;
    }

    /**
     * Sets time
     *
     * @param type $time            
     * @return void
     */
    public function setTime ($time)
    {
        $this->time = $time;
    }

    /**
     * Gets time
     *
     * @return type
     */
    public function getTime ()
    {
        return $this->time;
    }
}


?>