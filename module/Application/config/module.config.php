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

			'log-in' => [
				'type' => 'Literal',
				'options' => [
					'route' => '/sign-in',
				],
			],

			'log-out' => [
				'type' => 'Literal',
				'options' => [
					'route' => '/sign-out',
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

			'PlanningCenterOnline\Config' => function($sm) {
				$config = $sm->get('Config');
				$data   = isset($config['planning_center_online']) ? $config['planning_center_online'] : [];
				return new PlanningCenterOnline\Client\Config($data);
			},

			'PlanningCenterOnline\Client' => function($sm) {
				$config = $sm->get('PlanningCenterOnline\Config');
				return new PlanningCenterOnline\Client\Client($config);
			},

			'PlanningCenterOnline\Repository\PersonRepository' => function($sm) {
				$client = $sm->get('PlanningCenterOnline\Client');
				return new PlanningCenterOnline\Repository\PersonRepository($client);
			},

			'PlanningCenterOnline\Repository\OrganisationRepository' => function($sm) {
				$client = $sm->get('PlanningCenterOnline\Client');
				return new PlanningCenterOnline\Repository\OrganisationRepository($client);
			},

			'deit_authentication_form' => function() {
				return new Application\Form\Authentication();
			},

			'deit_authentication_adapter' => function($sm) {
				$service = $sm->get('PCOSync\Service\AuthenticationService');
				return new Application\Authentication\Adapter($service);
			},

		],
	],

	'controllers' => [
		'invokables' => [
			'Application\Controller\Index'          => 'Application\Controller\IndexController',
			'Application\Controller\Authentication' => 'Application\Controller\AuthenticationController',
			'Application\Controller\Settings'       => 'Application\Controller\SettingsController',
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
			'deit-authentication-module/log-in' => __DIR__.'/../view/application/admin/sign-in.phtml',
		],
		'template_path_stack' => [
			__DIR__.'/../view',
		],
	],

	'view_helpers' => [
		'factories' => [
			'PlanningCenterOnline' => function($sm) {
				$client = $sm->getServiceLocator()->get('PlanningCenterOnline\Client');
				return new Application\View\Helper\PlanningCenterOnline($client);
			},
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

	'deit_authentication' => [

		'map_auth_data_to_adapter_callback' => function(array $data, \Application\Authentication\Adapter $adapter) {

			if (isset($data['oauth_token'])) {
				$adapter->setToken($data['oauth_token']);
			}

			if (isset($data['oauth_verifier'])) {
				$adapter->setVerifier($data['oauth_verifier']);
			}

		},

		'fetch_entity_from_identity_callback' => function($identity, $sm) {
			return $sm->get('PCOSync\Service\AdministratorService')->findOneById($identity);
		},

	],

	'deit_authorisation' => [

		/**
		 * The service name of the unauthorised strategy
		 * @type    string
		 */
		'strategy'  => 'DeitAuthorisationModule\View\RedirectStrategy',

		/**
		 * The view template to display when the user is unauthorised
		 * @type    string
		 */
		'template'  => 'error/401',

		/**
		 * The route to redirect to when the user is unauthorised
		 * @type    string
		 */
		'route'     => 'log-in',

		/**
		 * The access control list
		 * @var array
		 */
		'acl'       => array(
			'roles'     => array(
				'guest',
				'admin' => 'guest'                                              //the admin role inherits guest permissions
			),
			'resources' => array(
				'DeitAuthenticationModule\\Controller\\Authentication\\log-in',
				'DeitAuthenticationModule\\Controller\\Authentication\\log-out',
				'Application',
			),
			'rules'     => array(
				'allow'     => array(
					'DeitAuthenticationModule\\Controller\\Authentication\\log-in'  => 'guest',
					'DeitAuthenticationModule\\Controller\\Authentication\\log-out' => 'admin',
					'Application' => 'admin'
				),
			),
		),

		/**
		 * The default role used when no authenticated identity is present or the identity's role can't be discovered
		 * @var string
		 */
		'default_role'  => 'guest',

		/**
		 * The role resolver used to discover the role of an identity when preset
		 * @var callable
		 */
		'role_resolver' => function($identity) {
			if ($identity) {
				return 'admin';
			} else {
				return 'guest';
			}
		},

	],

];
