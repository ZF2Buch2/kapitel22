<?php
/**
 * ZF2 Buch Kapitel 22
 * 
 * Das Buch "Zend Framework 2 - Von den Grundlagen bis zur fertigen Anwendung"
 * von Ralf Eggert ist im Addison-Wesley Verlag erschienen. 
 * ISBN 978-3-8273-2994-3
 * 
 * @package    Pizza
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Alle Listings sind urheberrechtlich geschützt!
 * @link       http://www.zendframeworkbuch.de/ und http://www.awl.de/2994
 */

/**
 * namespace definition and usage
 */
namespace Pizza;

use Zend\Filter\StaticFilter;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Pizza module class
 * 
 * @package    Pizza
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
            'Pizza\Service\PizzaService', 
            'set-pizza-form', 
            array($this, 'onFormSet')
        );

        // add table event
        $sharedEventManager->attach(
            'Pizza\Service\PizzaService',
            'set-pizza-table',
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
     * Inject Form defined by type to PizzaService when triggered
     *
     * @param EventInterface
     */
    public function onFormSet(EventInterface $e)
    {
        $type = $e->getParam('type', 'create');
        $service = $this->serviceLocator->get('Pizza\Service\Pizza');
        $form    = $this->serviceLocator->get('Pizza\Form\\' . ucfirst($type));
        $service->setForm($form, $type);
    }
    
    /**
     * Inject Table defined by type to PizzaService when triggered
     *
     * @param EventInterface
     */
    public function onTableSet(EventInterface $e)
    {
        $type      = $e->getParam('type', 'pizza');
        $tableName = StaticFilter::execute($type, 'wordunderscoretocamelcase');
        $service   = $this->serviceLocator->get('Pizza\Service\Pizza');
        $form      = $this->serviceLocator->get('Pizza\Table\\' . $tableName);
        $service->setTable($form, $type);
    }
}
