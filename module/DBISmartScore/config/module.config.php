<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'DBISmartScore\Controller\Index' => 'DBISmartScore\Controller\IndexController',
            'DBISmartScore\Controller\Consulta' => 'DBISmartScore\Controller\ConsultaController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'dbi-smartscore' => array(
                'type'    => 'Literal',
                'options' => array(
            		'route'    => '/dbismartscore',
            		'defaults' => array(
        				'__NAMESPACE__' => 'DBISmartScore\Controller',
        				'controller' => 'Index',
        				'action' => 'index',
            		),
                ),
                'may_terminate' => true,
                'child_routes' => array(
            		'default' => array(
        				'type'    => 'Segment',
        				'options' => array(
    						'route'    => '/[:controller[/:action]]',
    						'constraints' => array(
								'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
    						),
        				),
            		),
                ),
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
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            'DBISmartScore' => __DIR__ . '/../view',
        ),
        'strategies' => array(
    		'ViewJsonStrategy',
        ),
    ),
);
