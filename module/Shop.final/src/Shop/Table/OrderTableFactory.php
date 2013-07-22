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
namespace Shop\Table;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Order table factory
 * 
 * Generates the Order table object
 * 
 * @package    Shop
 */
class OrderTableFactory implements FactoryInterface
{
    /**
     * Create Service Factory
     * 
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $hydratorManager = $serviceLocator->get('HydratorManager');
        
        $adapter  = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $entity   = $serviceLocator->get('Shop\Entity\Order');
        $hydrator = $hydratorManager->get('Shop\Hydrator\Order');
        $table    = new OrderTable($adapter, $entity, $hydrator);
        return $table;
    }
}
