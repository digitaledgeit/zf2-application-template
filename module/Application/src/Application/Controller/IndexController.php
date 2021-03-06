<?php

namespace Application\Controller;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Index controller
 * @author James Newell <james@digitaledgeit.com.au>
 */
class IndexController extends AbstractActionController {

	/**
	 * Index action
	 * @return  mixed[]
	 */
	public function indexAction() {
		var_dump($this->identity()->getFirstName(), $this->identity()->getLastName(), $this->identity()->getEmail());
	}

}
