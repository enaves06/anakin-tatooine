<?php
namespace DBISmartScore\Service;
use Zend\ServiceManager\FactoryInterface;;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Json\Json;

class DBIwsServiceFactory implements FactoryInterface
{
    
    protected $services;
    
    protected static $config = array(
		'wsdl' => 'http://ws3.smartscore.com.br/DBIws.dll/wsdl/IDBIws',
		'proxy' => array(
			'proxy_host' => "192.168.2.252",
			'proxy_port' => 3128,
			'proxy_login' => "di",
			'proxy_password' => "jspecas0911"
		),
        'params' => array(
    		'usuario' => 'jspecas',
    		'senha' => 'd1611b11i987',
    		'CodigoConsulta' => '',
    		'Valor1' => '',
    		'Valor2' => '',
    		'Valor3' => '',
    		'Valor4' => '',
    		'Valor5' => ''
        )
    );
    
    /**
     * Init the service
     */
    public function init()
    {
    
    }
    
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return PedidoServiceFactory
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
    	$this->services = $serviceLocator;
    	// Call the init function of the form once the service manager is set
    	$this->init();
    	 
    	return $this;
    }
    
    /**
     * @return ServiceLocatorInterface $serviceLocator
     */
    public function getServiceLocator()
    {
    	return $this->services;
    }
    
    public static function consultarSintegra($cnpj, $uf)
    {
        
        static::$config['params']['CodigoConsulta'] = 1;
        static::$config['params']['Valor1'] = str_pad($cnpj, 14, "0", STR_PAD_LEFT);
        static::$config['params']['Valor2'] = strtoupper($uf);
        
        // Executa o soap
        $data = static::call();
        
        if(!isset($data->ResultadoConsulta)){
            throw new \Exception("Erro ao executar consulta.");
        }
        
        if(!isset($data->ResultadoConsulta->Registro)){
            switch ($data->ResultadoConsulta->CodErro) {
            	case 8:
            		throw new \Exception('Usuário não permitido para executar essa consulta.');
            	default:
            		throw new \Exception('[erro: '.$data->ResultadoConsulta->CodErro . ']' 
            		                      . ' ' . $data->ResultadoConsulta->Erro);
            }
        }    
        
        return array(
        	'situacao' => $data->ResultadoConsulta->Registro->Situacao,
            'cnpj' => $data->ResultadoConsulta->Registro->CNPJ,
            'ie' => $data->ResultadoConsulta->Registro->IE,
            'razaoSocial' => $data->ResultadoConsulta->Registro->RazaoSocial,
            'razaoSocialOriginal' => $data->ResultadoConsulta->Registro->RazaoSocialOriginal,
            'atividadeEconomica' => $data->ResultadoConsulta->Registro->AtividadeEconomica,
            'regimeApuracao' => $data->ResultadoConsulta->Registro->RegimeApuracao,
            'dataInclusao' => $data->ResultadoConsulta->Registro->DataInclusao,
            'dataBaixa' => $data->ResultadoConsulta->Registro->DataBaixa
        );
    }
    
    public static function consultarRF($cnpj)
    {
    
    	static::$config['params']['CodigoConsulta'] = 3;
    	static::$config['params']['Valor1'] = str_pad($cnpj, 14, "0", STR_PAD_LEFT);
    
    	// Executa o soap
    	$data = static::call();
    
    	if(!isset($data->ResultadoConsulta)){
    		throw new \Exception("Erro ao executar consulta.");
    	}
    
    	if(!isset($data->ResultadoConsulta->Registro)){
    		switch ($data->ResultadoConsulta->CodErro) {
    			case 8:
    				throw new \Exception('Usuário não permitido para executar essa consulta.');
    			default:
    				throw new \Exception('[erro: '.$data->ResultadoConsulta->CodErro . ']'
    						. ' ' . $data->ResultadoConsulta->Erro);
    		}
    	}
    	
    	return $data->ResultadoConsulta->Registro;
    }
    
    /**
     * 
     */
    protected static function call()
    {
        $client = new \SoapClient(static::$config['wsdl'], static::$config['proxy']);
        $xml = $client->__call("ConsultaOnLine", static::$config['params']);
        return Json::decode(Json::fromXml(utf8_decode($xml), true));
    }
    
}

?>