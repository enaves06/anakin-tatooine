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
        
        $service = $this->getServiceLocator()->get('DBISmartScore\Service\DBIws');
        $data = $service::consultarSintegra(4185877002280, 'GO');
        
        /*
        $_config = array(
    		'wsdl' => 'http://ws3.smartscore.com.br/DBIws.dll/wsdl/IDBIws',
    		'usuario' => 'jspecas',
    		'senha' => 'd1611b11i987',
    		'proxy' => array(
				'proxy_host' => "192.168.2.252",
				'proxy_port' => 3128,
				'proxy_login' => "di",
				'proxy_password' => "jspecas0911"
    		)
        );
        
        $params = array(
    		'usuario' => $_config['usuario'],
    		'senha' => $_config['senha'],
    		'CodigoConsulta' => 1,
    		'Valor1' => str_pad(4185877002280, 14, "0", STR_PAD_LEFT),
    		'Valor2' => 'GO',
    		'Valor3' => '',
    		'Valor4' => '',
    		'Valor5' => ''
        );
        
        $client = new \SoapClient($_config['wsdl'], $_config['proxy']);
        $xml = $client->__call("ConsultaOnLine", $params);
        $data = Json::decode(Json::fromXml($xml, true));
        
        print_r($data);
        */
        
        $result = new JsonModel(array(
    		"data" => array(),
    		"success" => true
        ));
        
        return $result;
    }
    
}
