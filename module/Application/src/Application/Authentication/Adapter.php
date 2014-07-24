<?php

namespace Application\Authentication;

use Zend\Authentication\Adapter\AdapterInterface;
use PCOSync\Service\AuthenticationService;

/**
 * OAuth adapter
 * @author James Newell <james@digitaledgeit.com.au>
 */
class Adapter implements AdapterInterface {

	/**
	 * The OAuth token
	 * @var     string
	 */
	private $token;

	/**
	 * The OAuth verifier
	 * @var     string
	 */
	private $verifier;

	/**
	 * The authentication service
	 * @var     AuthenticationService
	 */
	private $service;

	/**
	 * Construct the adapter
	 * @param   AuthenticationService $service
	 */
	public function __construct(AuthenticationService $service) {
		$this->service = $service;
	}

	/**
	 * Get the token
	 * @return  string
	 */
	public function getToken() {
		return $this->token;
	}

	/**
	 * Set the token
	 * @param   string $token
	 * @return  $this
	 */
	public function setToken($token) {
		$this->token = $token;
		return $this;
	}

	/**
	 * Get the verifier
	 * @return  string
	 */
	public function getVerifier() {
		return $this->verifier;
	}

	/**
	 * Set the verifier
	 * @param   string $verifier
	 * @return  $this
	 */
	public function setVerifier($verifier) {
		$this->verifier = $verifier;
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function authenticate() {
		return $this->service->authenticate(
			$this->getToken(),
			$this->getVerifier()
		);
	}

}
 