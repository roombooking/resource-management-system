<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\ModuleManager\ModuleManager;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;

class Module implements 
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ServiceProviderInterface
{
    public function onBootstrap(MvcEvent $e)
    {
        $app                 = $e->getApplication();
        $eventManager        = $app->getEventManager();
        $serviceManager      = $app->getServiceManager();
        
                
        $auth = $serviceManager->get('Application\Service\AuthService');
        
        $eventManager->attach(MvcEvent::EVENT_ROUTE, function($e) use ($auth) {
        	$match = $e->getRouteMatch();
        
        	// No route match, this is a 404
        	if (!$match instanceof RouteMatch) {
        		return;
        	}
        
        	// Route is whitelisted or User is authenticated
        	$name = $match->getMatchedRouteName();
        	if ($name == 'login' || $auth->hasIdentity()) {
        		return;
        	}
        
        	// Redirect to the user login page, as an example
        	$router   = $e->getRouter();
        	$url      = $router->assemble(array(), array(
        			'name' => 'login'
        	));
        
        	$response = $e->getResponse();
        	$response->getHeaders()->addHeaderLine('Location', $url);
        	$response->setStatusCode(302);
        
        	return $response;
        }, -100);

        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getServiceConfig()
    {
    	return include __DIR__ . '/config/services.config.php';
    }
    
    public function getControllerConfig()
    {
    	return include __DIR__ . '/config/controllers.config.php';
    }
    
    public function getControllerPluginConfig()
    {
        return include __DIR__ . '/config/controller.plugin.config.php';
    }
    
    public function getViewHelperConfig()
    {
    	return include __DIR__ . '/config/view.helper.config.php';    
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
		    // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }
}
