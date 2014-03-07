<?php
return array(
		'invokables' => array(
				'Application\Controller\Index' => 'Application\Controller\IndexController',
		),
		'factories' => array(
				'Application\Controller\Auth' => function($serviceLocator) {
				    $sl = $serviceLocator->getServiceLocator();
					return new \Application\Controller\AuthController(
					         $sl->get('Application\Service\AuthService'),
					         $sl->get('Application\Mapper\User'),
					         new \Application\Form\Login()
					);
				},
				'Application\Controller\User' => function($serviceLocator) {
				      $sl = $serviceLocator->getServiceLocator();
                      return new \Application\Controller\UserController(
                             $sl->get('Application\Mapper\User'),
                             $sl->get('Application\Mapper\Role')
		              );
				},
				'Application\Controller\Power' => function($serviceLocator) {
				    $sl = $serviceLocator->getServiceLocator();
					return new \Application\Controller\PowerController(
							$sl->get('Application\Mapper\Power'),
							$sl->get('Application\Mapper\Role'),
					        new \Application\Form\Power()
					);
				},
				'Application\Controller\Booking' => function($serviceLocator) {
				    $sl = $serviceLocator->getServiceLocator();
					return new \Application\Controller\BookingController(
							$sl->get('Application\Mapper\Booking'),
							new \Application\Form\Booking($sl->get('Application\Mapper\User'))
					);
				},
				'Application\Controller\Resource' => function($serviceLocator) {
					$sl = $serviceLocator->getServiceLocator();
					return new \Application\Controller\ResourceController(
							$sl->get('Application\Mapper\Resource')
					);
				}
		),

);