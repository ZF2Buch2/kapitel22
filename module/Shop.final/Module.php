<?php
/**
 * ZF2 Buch Kapitel 22
 * 
 * Das Buch "Zend Framework 2 - Das Praxisbuch"
 * von Ralf Eggert ist im Galileo-Computing Verlag erschienen. 
 * ISBN 978-3-8362-2610-3
 * 
 * @package    Shop
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Alle Listings sind urheberrechtlich geschützt!
 * @link       http://www.zendframeworkbuch.de/ und http://www.galileocomputing.de/3460
 */

/**
 * namespace definition and usage
 */
namespace Shop;

use Zend\Filter\StaticFilter;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Shop module class
 * 
 * @package    Shop
 */
class Module implements 
    BootstrapListenerInterface,
    ConfigProviderInterface, 
    AutoloaderProviderInterface
{
    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator = null;
    
    /**
     * Listen to the bootstrap event
     *
     * @return array
     */
    public function onBootstrap(EventInterface $e)
    {
        // set service locator
        $this->serviceLocator = $e->getApplication()->getServiceManager();
        
        // get shared event manager
        $sharedEventManager = $this->serviceLocator->get('SharedEventManager');
        
        // add form event
        $sharedEventManager->attach(
            'Shop\Service\OrderService', 
            'set-order-form', 
            array($this, 'onFormSet')
        );

        // add table event
        $sharedEventManager->attach(
            'Shop\Service\OrderService',
            'set-order-table',
            array($this, 'onTableSet')
        );
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
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    /**
     * Inject Form defined by type to OrderService when triggered
     *
     * @param EventInterface
     */
    public function onFormSet(EventInterface $e)
    {
        $type = $e->getParam('type', 'create');
        $service = $this->serviceLocator->get('Shop\Service\Order');
        $form    = $this->serviceLocator->get('Shop\Form\\' . ucfirst($type));
        $service->setForm($form, $type);
    }
    
    /**
     * Inject Table defined by type to OrderService when triggered
     *
     * @param EventInterface
     */
    public function onTableSet(EventInterface $e)
    {
        $type       = $e->getParam('type', 'order');
        $tableClass = $type == 'user' ? 'User\Table\User' : 'Shop\Table\Order';
        $service   = $this->serviceLocator->get('Shop\Service\Order');
        $form      = $this->serviceLocator->get($tableClass);
        $service->setTable($form, $type);
    }
}
