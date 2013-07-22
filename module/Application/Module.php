<?php
/**
 * ZF2 Buch Kapitel 22
 * 
 * Das Buch "Zend Framework 2 - Das Praxisbuch"
 * von Ralf Eggert ist im Galileo-Computing Verlag erschienen. 
 * ISBN 978-3-8362-2610-3
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Alle Listings sind urheberrechtlich geschützt!
 * @link       http://www.zendframeworkbuch.de/ und http://www.galileocomputing.de/3460
 */

/**
 * namespace definition and usage
 */
namespace Application;

use Application\Listener\ApplicationListener;
use Zend\EventManager\EventInterface;
use Zend\Filter\StaticFilter;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\Config\SessionConfig;
use Zend\Validator\StaticValidator;

/**
 * Application module class
 * 
 * @package    Application
 */
class Module implements 
    BootstrapListenerInterface,
    ConfigProviderInterface,
    AutoloaderProviderInterface
{
    /**
     * Listen to the bootstrap event
     *
     * @param MvcEvent $e
     * @return void
     */
    public function onBootstrap(EventInterface $e)
    {
        // get managers
        $eventManager   = $e->getApplication()->getEventManager();
        $serviceManager = $e->getApplication()->getServiceManager();
        
        // attach module listener
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        // add application listener
        $eventManager->attachAggregate(new ApplicationListener());
        
        // get config
        $config = $serviceManager->get('config');
        
        // configure session
        $sessionConfig = new SessionConfig();
        $sessionConfig->setOptions($config['session']);
        
        // get filter and validator manager 
        $filterManager    = $serviceManager->get('FilterManager');
        $validatorManager = $serviceManager->get('ValidatorManager');
        
        // add custom filters and validators
        StaticFilter::setPluginManager($filterManager);
        StaticValidator::setPluginManager($validatorManager);
    }

    /**
     * Returns configuration to merge with application configuration
     *
     * @return array|\Traversable
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * Return an array for passing to Zend\Loader\AutoloaderFactory.
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                'application' => __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
