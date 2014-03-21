<?php
return array(
		'factories' => array(
				'userDisplayName' => function ($sm) {
					$locator = $sm->getServiceLocator();
					$viewHelper = new \Application\View\Helper\UserDisplayName;
					$viewHelper->setAuthService($locator->get('Application\Service\AuthService'));
					return $viewHelper;
				},
				'userIdentity' => function ($sm) {
					$locator = $sm->getServiceLocator();
					$viewHelper = new \Application\View\Helper\UserIdentity;
					$viewHelper->setAuthService($locator->get('Application\Service\AuthService'));
					return $viewHelper;
				},
		),
);