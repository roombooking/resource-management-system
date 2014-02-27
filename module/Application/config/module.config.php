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
            'api' => array(
            		'type' => 'Literal',
            		'options' => array(
            				'route'    => '/api/bookings',
            				'scheme'   => 'https',
            				'defaults' => array(
            						'__NAMESPACE__' => 'Application\Controller',
            						'controller' => 'ApiBooking',
            						'action'     => 'apibooking',
            				),
            				'constraints' => array(
            						'type' => '[a-zA-Z0-9_-]+'
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
            'user' => array(
            		'type' => 'Literal',
            		'options' => array(
            				'route'    => '/users',
            				'scheme'   => 'https',
            				'defaults' => array(
            						'__NAMESPACE__' => 'Application\Controller',
            						'controller' => 'User',
            						'action'     => 'index',
            				),
            		),
            		'may_terminate' => true,
            		'child_routes' => array(
            				'refresh' => array(
            						'type'    => 'Literal',
            						'options' => array(
            								'route'    => '/refresh',
            								'defaults' => array(
            										'action' => 'refresh',
            								),
            						),
            				),
            				'update' => array(
            						'type'    => 'Literal',
            						'options' => array(
            								'route'    => '/update',
            								'defaults' => array(
            										'action' => 'edit',
            								),
            						),
            				),
            		),
            ),
        ),
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
