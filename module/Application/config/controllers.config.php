<?php
return array(
		'invokables' => array(
				'Application\Controller\Index' => 'Application\Controller\IndexController',
		),
		'factories' => array(
				'Application\Controller\Auth' => function($serviceLocator) {
					$ctr = new \Application\Controller\AuthController();

					$ctr->setLoginForm(new \Application\Form\Login());
					$ctr->setAuthService($serviceLocator->getServiceLocator()->get('Application\Service\AuthService'));

					return $ctr;
				},
				'Application\Controller\User' => function($serviceLocator) {
					return new \Application\Controller\UserController($serviceLocator->getServiceLocator()->get('Application\Mapper\User'));
				},
		),

);