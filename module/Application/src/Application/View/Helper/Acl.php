<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Acl Helper
 *
 * @author Roombooking Study Project (see AUTHORS.md)
 *
 * @version 0.1
 *
 */
class Acl extends AbstractHelper
{
    /**
     * @var AuthenticationService
     */
    protected $acl;

    /**
     * __invoke
     *
     * @access public
     * @return 
     */
    public function __invoke()
    {
        return $this->acl->getAcl();
    }

    /**
     * Get authService.
     *
     * @return Acl
     */
    public function getAcl()
    {
        return $this->acl;
    }

    /**
     * Set Acl.
     *
     * @param $acl
     * @return \Application\View\Helper\Acl
     */
    public function setAcl($acl)
    {
        $this->acl = $acl;
        return $this;
    }
}