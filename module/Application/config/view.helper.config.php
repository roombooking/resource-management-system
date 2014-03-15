<?php
return array(
		'factories' => array(
				'UserDisplayName' => function ($sm) {
					$locator = $sm->getServiceLocator();
					$viewHelper = new View\Helper\UserDisplayName;
					$viewHelper->setAuthService($locator->get('Application\Service\AuthService'));
					return $viewHelper;
				},
				'UserIdentity' => function ($sm) {
					$locator = $sm->getServiceLocator();
					$viewHelper = new View\Helper\UserIdentity;
					$viewHelper->setAuthService($locator->get('Application\Service\AuthService'));
					return $viewHelper;
				},
		),
);