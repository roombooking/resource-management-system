<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                    'type' => 'Literal',
                    'options' => array(
                            'route'    => '/',
                            'scheme'   => 'https',
                            'defaults' => array(
                                    '__NAMESPACE__' => 'Application\Controller',    
                                    'controller' => 'Index',
                                    'action'     => 'index',
                            ),
                    ),
            ),
            'login' => array(
            		'type' => 'Literal',
            		'options' => array(
            				'route'    => '/login',
            				'scheme'   => 'https',
            				'defaults' => array(
            				        '__NAMESPACE__' => 'Application\Controller',
            						'controller' => 'Auth',
            						'action'     => 'login',
            				),
            		),
            		'may_terminate' => true,
            		'child_routes' => array(
            				'loginCheck' => array(
            						'type'    => 'Literal',
            						'options' => array(
            								'route'    => '/check',
            								'defaults' => array(
            										'action' => 'check',
            								),
            						),
            				),
            		),
            ),
            'logout' => array(
            		'type' => 'Literal',
            		'options' => array(
            				'route'    => '/logout',
            				'scheme'   => 'https',
            				'defaults' => array(
            				        '__NAMESPACE__' => 'Application\Controller',
            						'controller' => 'Auth',
            						'action'     => 'logout',
            				),
            		),
            ),
        ),
    ),
    'service_manager' => array(
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
        	       'driver'    => 'pdo',
        	       'dsn'       => 'mysql:dbname='.$dbParams['database'].';host='.$dbParams['hostname'],
        	       'database'  => $dbParams['hostname'],
        	       'username'  => $dbParams['username'],
        	       'password'  => $dbParams['password'],
        	       'hostname'  => $dbParams['hostname'],
        	   ));
            },
            'Application\Service\AuthService' => 'Application\Service\AuthServiceFactory'
        )
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController',
        ),
        'factories' => array(
            'Application\Controller\Auth' => 'Application\Controller\AuthControllerFactory',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'layout/login'           => __DIR__ . '/../view/layout/login.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
        		'ViewJsonStrategy',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
