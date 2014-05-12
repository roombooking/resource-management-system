<?php

namespace Application\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Authentication\AuthenticationService;

/**
 * UserAuthentication
 *
 * A set of convenience methods, allowing to access the authentication
 * status of a user from controllers without injecting the user mappes.
 *
 * @author Roombooking Study Project (see AUTHORS.md)
 *
 * @version 0.1
 *
 */

class UserAuthentication extends AbstractPlugin
{

    /**
     * @var AuthenticationService
     */
    protected $authService;

    /**
     * Proxy convenience method returning whether the user calling
     * the controller has an identity (is logged in) or not.
     *
     * @return bool
     */
    public function hasIdentity()
    {
        return $this->getAuthService()->hasIdentity();
    }

    /**
     * Proxy convenience method providing the identity of a user
     * logged in.
     *
     * @return mixed
     */
    public function getIdentity()
    {
        $identity = $this->getAuthService()->getIdentity();
    	return $identity['userid'];
    }
    
    /**
     * Proxy convenience method providing the role of a user
     * logged in.
     *
     * @return mixed
     */
    public function getRole()
    {
        $identity = $this->getAuthService()->getIdentity();
    	return $identity['role'];
    }
    

    /**
     * Get authService.
     *
     * @return AuthenticationService
     */
    public function getAuthService()
    {
        return $this->authService;
    }

    /**
     * Set authService.
     *
     * @param AuthenticationService $authService
     */
    public function setAuthService(AuthenticationService $authService)
    {
        $this->authService = $authService;
        return $this;
    }

}