<?php

namespace PhpExcel;

use Zend\Loader\StandardAutoloader;
use Zend\Loader\AutoloaderFactory;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\Mvc\MvcEvent;

/**
 * Module class
 *
 * @category   AssetManager
 * @package    AssetManager
 */
class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    BootstrapListenerInterface
{
    /**
     * {@inheritDoc}
     */
    public function getAutoloaderConfig()
    {
        return array(
            AutoloaderFactory::STANDARD_AUTOLOADER => array(
                StandardAutoloader::LOAD_NS => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }
    
    public function onDispatch(MvcEvent $event)
    {
        $response = $event->getResponse();
        if (!method_exists($response, 'getStatusCode') || $response->getStatusCode() !== 404) {
            return;
        }
        return;
    }
    
    /**
     * {@inheritDoc}
     */
    public function onBootstrap(EventInterface $event)
    {
        // Attach for dispatch, and dispatch.error (with low priority to make sure statusCode gets set)
        $eventManager = $event->getTarget()->getEventManager();
        $callback     = array($this, 'onDispatch');
        $priority     = -9999999;
        $eventManager->attach(MvcEvent::EVENT_DISPATCH,       $callback, $priority);
        $eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, $callback, $priority);
    }
}
