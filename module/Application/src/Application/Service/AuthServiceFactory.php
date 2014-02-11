<?php
namespace Application\Service;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Authentication\Storage\Session;
use Zend\Authentication\Adapter\Ldap;

class AuthServiceFactory implements FactoryInterface
{
    const TABLE_NAME = "users";
    const IDENTITY_COLUMN = "username";
    
    public function createService (ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $options = $config['ldap'];
        $service = new \Zend\Authentication\AuthenticationService(
                new Session(),
                new Ldap($options)
        );
        
        return $service;
    }
}