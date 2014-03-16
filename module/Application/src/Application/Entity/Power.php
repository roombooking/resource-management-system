<?php
namespace Application\Entity;

/**
 * Power Entity
 *
 * This entity represents the powers assigned to a specific role.
 *
 * @author Roombooking Study Project (see AUTHORS.md)
 *
 * @version 0.1
 *
 */

class Power
{
    //FIXME: Hydrator?
    protected $powerid = 0;
    protected $roleid = 0;
    protected $module = '';
    protected $controller = '';
    protected $action = '';

    /**
    * Legt powerid fest
    *
    * @param type $powerid
    * @return void
    */
    public function setPowerId($powerid)
    {
    	$this->powerid = $powerid;
    }
    
    /**
    * Legt roleid fest
    *
    * @param type $roleid
    * @return void
    */
    public function setRoleId($roleid)
    {
    	$this->roleid = $roleid;
    }
    
    /**
    * Legt module fest
    *
    * @param type $module
    * @return void
    */
    public function setModule($module)
    {
    	$this->module = $module;
    }
    
    /**
    * Legt controller fest
    *
    * @param type $controller
    * @return void
    */
    public function setController($controller)
    {
    	$this->controller = $controller;
    }
    
    /**
    * Legt action fest
    *
    * @param type $action
    * @return void
    */
    public function setAction($action)
    {
    	$this->action = $action;
    }
    
    /**
    * Gibt action zurück
    *
    * @return type
    */
    public function getAction()
    {
    	return $this->action;
    }
    
    /**
    * Gibt controller zurück
    *
    * @return type
    */
    public function getController()
    {
    	return $this->controller;
    }
    
    /**
    * Gibt module zurück
    *
    * @return type
    */
    public function getModule()
    {
    	return $this->module;
    }
    
    /**
    * Gibt roleid zurück
    *
    * @return type
    */
    public function getRoleId()
    {
    	return $this->roleid;
    }
    
    /**
    * Gibt powerid zurück
    *
    * @return type
    */
    public function getPowerId()
    {
    	return $this->powerid;
    }
}