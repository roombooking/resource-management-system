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
            				'defaults' => array(
            						'__NAMESPACE__' => 'Application\Controller',
            						'controller' => 'User',
            						'action'     => 'index',
            				),
            		),
            		'may_terminate' => true,
            		'child_routes' => array(
            				'userRefresh' => array(
            						'type'    => 'Literal',
            						'options' => array(
            								'route'    => '/refresh',
            								'defaults' => array(
            										'action' => 'refresh',
            								),
            						),
            				),
            				'userUpdate' => array(
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
            'booking' => array(
            		'type' => 'Literal',
            		'options' => array(
            				'route'    => '/bookings',
            				'defaults' => array(
            						'__NAMESPACE__' => 'Application\Controller',
            						'controller' => 'Booking',
            						'action'     => 'index',
            				),
            		),
            		'may_terminate' => true,
                        'child_routes' => array(
                                /*
                                 * The list/api route returns a JSON representation of
                                 * bookings from given start/end values, provided as
                                 * GET parameters.
                                 */
                                'bookingList' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                                'route' => '/list/api',
                                                'defaults' => array(
                                                        'action' => 'list'
                                                )
                                        )
                                ),
                                'bookingAdd' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                                'route' => '/add',
                                                'defaults' => array(
                                                        'action' => 'add'
                                                )
                                        )
                                ),
                                /* 
                                 * The details/:id/api route returns a JSON representation of
                                 * all details available for a given booking id.
                                 */
                                'bookingDetails' => array(
                                		'type' => 'Segment',
                                		'options' => array(
                                				'route' => '/:id/details/api',
                                				'constraints' => array(
                                						'id' => '[0-9]+'
                                				),
                                				'defaults' => array(
                                						'action' => 'details'
                                				)
                                		)
                                ),
                                'bookingShow' => array(
                                		'type' => 'Segment',
                                		'options' => array(
                                				'route' => '/:id/show',
                                				'constraints' => array(
                                						'id' => '[0-9]+'
                                				),
                                				'defaults' => array(
                                						'action' => 'show'
                                				)
                                		)
                                )
                        ),
            ),
            'resource' => array(
            		'type' => 'Literal',
            		'options' => array(
            				'route'    => '/resources',
            				'scheme'   => 'https',
            				'defaults' => array(
            						'__NAMESPACE__' => 'Application\Controller',
            						'controller' => 'Resource',
            						'action'     => 'index',
            				),
            		),
            		'may_terminate' => true,
            		'child_routes' => array(
            				'containment' => array(
            						'type' => 'Literal',
            						'options' => array(
            								'route' => '/containment/api',
            								'defaults' => array(
            										'action' => 'containment'
            								)
            						)
            				)
            		)
            ),
            'power' => array(
            		'type' => 'Literal',
            		'options' => array(
            				'route'    => '/powers',
            				'scheme'   => 'https',
            				'defaults' => array(
            						'__NAMESPACE__' => 'Application\Controller',
            						'controller' => 'Power',
            						'action'     => 'overview',
            				),
            		),
            		'may_terminate' => true,
            		'child_routes' => array(
            				'powerAdd' => array(
            						'type'    => 'Literal',
            						'options' => array(
            								'route'    => '/add',
            								'defaults' => array(
            										'action' => 'add',
            								),
            						),
            				),
            				'powerEdit' => array(
            						'type'    => 'Segment',
            						'options' => array(
            								'route'    => '/edit/:id',
            								'constraints' => array(
            										'id' => '[0-9]+',
            								),
            								'defaults' => array(
            										'action' => 'edit',
            								),
            						),
            				),
            				'powerDelete' => array(
            						'type'    => 'Segment',
            						'options' => array(
            								'route'    => '/delete/:id',
            								'constraints' => array(
            					                    'id' => '[0-9]+',
            				                ),
            								'defaults' => array(
            										'action' => 'delete',
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
            'layout/login'            => __DIR__ . '/../view/layout/login.phtml',
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
