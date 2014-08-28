<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/JSApi for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace DBISmartScore\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\Json\Json;

class ConsultaController extends AbstractActionController
{
    public function indexAction()
    {
        return array();
    }

    public function fooAction()
    {
        // This shows the :controller and :action parameters in default route
        // are working when you browse to /index/index/foo
        return array();
    }
    
    public function sintegraAction()
    {
        set_time_limit(0);
        $service = $this->getServiceLocator()->get('DBISmartScore\Service\DBIws');
        $data = $service::consultarSintegra(42357483000630, 'PE');
        
        $result = new JsonModel(array(
    		"data" => $data,
    		"success" => true
        ));
        
        return $result;
    }
    
}
