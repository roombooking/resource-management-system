<?php
namespace Application\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Form\Login;

class AuthControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $ctr = new AuthController();
        $ctr->setLoginForm(new Login());
        
        $ctr->setAuthService($serviceLocator->getServiceLocator()->get('Application\Service\AuthService'));
        
        return $ctr;
    }
}

?>