<?php

namespace App\Controller\Gdv;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexTesteController extends AbstractActionController
{    
    public function indexAction(){
    	$sm = $this->getServiceLocator();
        $adapter = $sm->get('Zend\Db\Adapter\Mysql');

        $statement = $adapter->createStatement($sql);
		$result = $statement->execute();

		print_r($result->current());
    }
}
