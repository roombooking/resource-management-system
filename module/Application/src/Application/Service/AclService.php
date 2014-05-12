<?php
namespace Application\Service;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;

class AclService
{
    /**
     * @var Application\Mapper\Power
     */
    private $powerMapper;
    
    /**
     * @var Zend\Permissions\Acl\Acl
     */
    private $acl;
    
    public function __construct($_mapper) {
        $this->powerMapper = $_mapper;
        
        $this->acl = new Acl();
        $this->initAcl();
    }
    
    private function initAcl()
    {        
        $powers = $this->powerMapper->fetchAll();
        
        foreach($powers as $power) {
            // Add new roles
            if(!$this->acl->hasRole($power->getRoleId())) {
                $this->acl->addRole(new Role($power->getRoleId()));
            }
            // Add new resources
            if(!$this->acl->hasResource($power->getAction()) && ($power->getAction() != "%")) {
                $this->acl->addResource(new Resource($power->getAction()));
            }
            // allow role access to resource
            if($power->getAction() == "%") {
                $this->acl->allow($power->getRoleId());
            } else {
                $this->acl->allow($power->getRoleId(), $power->getAction());
            }
        }
    }
    
    public function isAllowed($user = null, $privilege = null)
    {
        if($this->acl->hasRole($user) && $this->acl->hasResource($privilege)) {
            return $this->acl->isAllowed($user, $privilege);
        } else {
            return false;
        }
    }
    
    public function getAcl() {
        return $this->acl;
    }
}