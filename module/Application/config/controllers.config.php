<?php
return array(
		'invokables' => array(
				'Application\Controller\Index' => 'Application\Controller\IndexController',
		),
		'factories' => array(
				'Application\Controller\Auth' => function($serviceLocator) {
					return new \Application\Controller\AuthController(
					         $serviceLocator->getServiceLocator()->get('Application\Service\AuthService'),
					         $serviceLocator->getServiceLocator()->get('Application\Mapper\User'),
					         new \Application\Form\Login()
					);
				},
				'Application\Controller\User' => function($serviceLocator) {
                      return new \Application\Controller\UserController(
                             $serviceLocator->getServiceLocator()->get('Application\Mapper\User'),
                             $serviceLocator->getServiceLocator()->get('Application\Mapper\Role')
		              );
				},
				'Application\Controller\ApiBooking' => function($serviceLocator) {
					return new \Application\Controller\ApiBookingController(
							$serviceLocator->getServiceLocator()->get('Application\Mapper\Booking')
					);
				},
		),

);