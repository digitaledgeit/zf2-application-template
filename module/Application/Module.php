<?php

namespace Application;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\ModuleRouteListener;

/**
 * Module
 * @author James Newell <james@digitaledgeit.com.au>
 */
class Module {

	/**
	 * @inheritdoc
	 */
	public function getConfig() {
		return include __DIR__.'/config/module.config.php';
	}

	/**
	 * @inheritdoc
	 */
	public function getAutoloaderConfig() {
		return array(
			'Zend\Loader\StandardAutoloader' => [
				'namespaces' => [
					__NAMESPACE__ => __DIR__.'/src/'.__NAMESPACE__,
				],
			],
		);
	}

	/**
	 * @inheritdoc
	 */
	public function onBootstrap(MvcEvent $event) {
		$eventManager        = $event->getApplication()->getEventManager();
		$moduleRouteListener = new ModuleRouteListener();
		$moduleRouteListener->attach($eventManager);
	}

}
