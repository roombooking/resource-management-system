<?php
return array(
		'factories' => array(
				'userAuthentication' => function ($sm) {
					$serviceLocator = $sm->getServiceLocator();
					$authService = $serviceLocator->get('Application\Service\AuthService');
					$controllerPlugin = new Application\Controller\Plugin\UserAuthentication;
					$controllerPlugin->setAuthService($authService);
					return $controllerPlugin;
				},
				'logger' => function ($sm) {
					$serviceLocator = $sm->getServiceLocator();
					$incidentMapper = $serviceLocator->get('Application\Mapper\Incident');
					$controllerPlugin = new Application\Controller\Plugin\Logger;
					$controllerPlugin->setIncidentMapper($incidentMapper);
					return $controllerPlugin;
				},
		),
);