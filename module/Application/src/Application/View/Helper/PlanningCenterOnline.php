<?php

namespace Application\View\Helper;
use PlanningCenterOnline\Client\Client;
use Zend\View\Helper\AbstractHelper;

/**
 * Planning Center Online
 * @author James Newell <james@digitaledgeit.com.au>
 */
class PlanningCenterOnline extends AbstractHelper {

	/**
	 * The client
	 * @var     Client
	 */
	private $client;

	/**
	 * Construct the helper
	 * @param   Client $client
	 */
	public function __construct(Client $client) {
		$this->client = $client;
	}

	/**
	 * Get the authorisation URL
	 * @return  string
	 */
	public function getAuthorisationUrl() {
		return $this->client->getAuthorisationUrl();
	}

}
 