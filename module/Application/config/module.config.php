<?php

return [

	'router' => [
		'routes' => [

			'home' => [
				'type' => 'Literal',
				'options' => [
					'route' => '/',
					'defaults' => [
						'controller' => 'Application\Controller\Index',
						'action' => 'index',
					],
				],
			],

			'app' => [
				'type' => 'Literal',
				'options' => [
					'route' => '/app',
					'defaults' => [
						'__NAMESPACE__' => 'Application\Controller',
						'controller' => 'Index',
						'action' => 'index',
					],
				],
				'may_terminate' => true,
				'child_routes' => [
					'default' => [
						'type' => 'Segment',
						'options' => [
							'route' => '/[:controller[/:action]]',
							'constraints' => [
								'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							],
						],
					],
				],
			],

		],
	],

	'service_manager' => [
		'factories' => [
			'Navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
		],
	],

	'controllers' => [
		'invokables' => [
			'Application\Controller\Index' => 'Application\Controller\IndexController'
		],
	],

	'translator' => [
		'locale' => 'en_US',
		'translation_file_patterns' => [
			[
				'type' => 'gettext',
				'base_dir' => __DIR__.'/../language',
				'pattern' => '%s.mo',
			],
		],
	],

	'view_manager' => [
		'display_not_found_reason' => true,
		'display_exceptions' => true,
		'doctype' => 'HTML5',
		'not_found_template' => 'error/404',
		'exception_template' => 'error/index',
		'template_map' => [
			'layout/layout' => __DIR__.'/../view/layout/layout.phtml',
			'application/index/index' => __DIR__.'/../view/application/index/index.phtml',
			'error/404' => __DIR__.'/../view/error/404.phtml',
			'error/index' => __DIR__.'/../view/error/index.phtml',
		],
		'template_path_stack' => [
			__DIR__.'/../view',
		],
	],

	'navigation' => [
		'default' => [

			'home' => [
				'label' => 'Home',
				'route' => 'home',
				'icon' => 'fa fa-home',
			],
			
		],
	],

	'doctrine' => [
		'driver' => [

			'my_annotation_driver' => [
				'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
				'cache' => 'array',
				'paths' => [
					__DIR__.'/../src/Application/Entity',
				],
			],

			'orm_default' => [
				'drivers' => [
					'Application\Entity' => 'my_annotation_driver'
				],
			],
		],
	],

];
