<?php

namespace Application\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Application\Entity\Incident as IncidentEntity;
use Application\Mapper\Incident;

/**
 * Logger
 *
 * A set of convenience methods, allowing to log the changes
 *
 * @author Roombooking Study Project (see AUTHORS.md)
 *
 * @version 0.1
 *
 */

class Logger extends AbstractPlugin
{

    /**
     * @var Incident
     */
    private $incidentMapper;

    /**
     * Function to insert a new log event into the database
     * 
     * TODO: PHP Enum integration / check
     * TODO: maybe replace $userid = null with $this->userAuthentication()->getIdentity()
     * 
     * @param int $class 0 = INFO, 1 = WWARNING, 2 = ERROR, 3 = CRITICAL
     * @param string $description
     * @param string $userid
     * @param string $bookingid
     * @param string $resourceid
     */
    public function insert($class, $description, $userid = null, $bookingid = null, $resourceid = null)
    {
        $incident = new IncidentEntity();
        $incident->setClass($class);
        $incident->setDescription($description);
        $incident->setUserId($userid);
        $incident->setBookingId($bookingid);
        $incident->setResourceId($resourceid);
        
        $this->incidentMapper->insert($incident);
        unset($incident);
    }


    /**
     * Get IncidentMapper.
     *
     * @return Icident $incidentMapper
     */
    public function getIncidentMapper()
    {
        return $this->incidentMapper;
    }

    /**
     * Set IncidentMapper.
     *
     * @param $incidentMapper
     */
    public function setIncidentMapper(Incident $incidentMapper)
    {
        $this->incidentMapper = $incidentMapper;
        return $this;
    }

}