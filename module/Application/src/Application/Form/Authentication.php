<?php

namespace Application\Form;
use DeitAuthenticationModule\Form\AbstractAuthentication;
use Zend\Http\Request;

/**
 * Authentication form
 * @author James Newell <james@digitaledgeit.com.au>
 */
class Authentication extends AbstractAuthentication {

	/** @inheritdoc */
	public function __construct() {
		parent::__construct('auth');

		$this->setAttribute('method', 'GET');

		$this->add([
			'type' => 'text',
			'name' => 'oauth_token'
		]);

		$this->add([
			'type' => 'text',
			'name' => 'oauth_verifier'
		]);

	}

	/** @inheritdoc */
	public function isSubmitted(Request $request) {
		return $request->isGet() && $request->getQuery('oauth_token') && $request->getQuery('oauth_verifier');
	}

}
 