<?php
namespace Application\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class ApplicationAcl extends AbstractPlugin
{
    /**
     * @var Application\Mapper\Power
     */
    private $aclService;
    
    public function __construct($_service) {
        $this->aclService = $_service;
    }
    
    public function isAllowed($user = null, $privilege = null)
    {
        return $this->aclService->isAllowed($user, $privilege);
        //return $this->aclService->isAllowed($user, $privilege) ? 'allowed' : 'denied';
    }
    
    public function getAcl() {
        return $this->aclService->getAcl();
    }
}