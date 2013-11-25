<?php

return array(

	'service_manager' => array(
		'factories' => array(
			'Navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
		),
	),

	'router' => array(
		'routes' => array(

			'home' => array(
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => array(
					'route' => '/',
					'defaults' => array(
						'controller' => 'Application\Controller\Index',
						'action' => 'index',
					),
				),
			),

			'app' => array(
				'type' => 'Literal',
				'options' => array(
					'route' => '/application',
					'defaults' => array(
						'__NAMESPACE__' => 'Application\Controller',
						'controller' => 'Index',
						'action' => 'index',
					),
				),
				'may_terminate' => true,
				'child_routes' => array(
					'default' => array(
						'type' => 'Segment',
						'options' => array(
							'route' => '/[:controller[/:action]]',
							'constraints' => array(
								'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							),
							'defaults' => array(),
						),
					),
				),
			),

		),
	),

	'controllers' => array(
		'invokables' => array(
			'Application\Controller\Index' => 'Application\Controller\IndexController'
		),
	),

	'translator' => array(
		'locale' => 'en_US',
		'translation_file_patterns' => array(
			array(
				'type' => 'gettext',
				'base_dir' => __DIR__.'/../language',
				'pattern' => '%s.mo',
			),
		),
	),

	'view_manager' => array(
		'display_not_found_reason' => true,
		'display_exceptions' => true,
		'doctype' => 'HTML5',
		'not_found_template' => 'error/404',
		'exception_template' => 'error/index',
		'template_map' => array(
			'layout/layout' => __DIR__.'/../view/layout/layout.phtml',
			'application/index/index' => __DIR__.'/../view/application/index/index.phtml',
			'error/404' => __DIR__.'/../view/error/404.phtml',
			'error/index' => __DIR__.'/../view/error/index.phtml',
		),
		'template_path_stack' => array(
			__DIR__.'/../view',
		),
	),

	'navigation' => array(
		'default' => array(

			'home' => array(
				'label' => 'Home',
				'route' => 'home',
				'icon' => 'fa fa-home',
			),
			
		),
	),

);
