<?php
return array(
        'abstract_factories' => array(
        		'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
        		'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
        		'translator' => 'MvcTranslator',
        ),
        'factories' => array(
        		'Zend\Db\Adapter\Adapter' => function ($sm) {
        			$config = $sm->get('Config');
        			$dbParams = $config['dbParams'];
        
        			return new Zend\Db\Adapter\Adapter(array(
        					'driver'    => 'Pdo_Mysql',
        					'dsn'       => 'mysql:dbname='.$dbParams['database'].';host='.$dbParams['hostname'],
        					'database'  => $dbParams['hostname'],
        					'username'  => $dbParams['username'],
        					'password'  => $dbParams['password'],
        					'hostname'  => $dbParams['hostname'],
        			));
        		},
        		'Application\Service\AuthService' => function ($sm) {
        			$config = $sm->get('Config');
        			$options = $config['ldap'];
        			return new \Zend\Authentication\AuthenticationService(
        					new Zend\Authentication\Storage\Session(),
        					new Zend\Authentication\Adapter\Ldap($options)
        			);
        		},
        		'Application\Mapper\User' => function ($sm) {
        			return new \Application\Mapper\User(
        					$sm->get('Zend\Db\Adapter\Adapter')
        			);
        		},
        		'Application\Mapper\Role' => function ($sm) {
        			return new \Application\Mapper\Role(
        					$sm->get('Zend\Db\Adapter\Adapter')
        			);
        		},
        		'Application\Mapper\Booking' => function ($sm) {
        			return new \Application\Mapper\Booking(
        					$sm->get('Zend\Db\Adapter\Adapter')
        			);
        		},
        ),
);