<?php
/**
 * ZF2 Buch Kapitel 22
 * 
 * Das Buch "Zend Framework 2 - Das Praxisbuch"
 * von Ralf Eggert ist im Galileo-Computing Verlag erschienen. 
 * ISBN 978-3-8362-2610-3
 * 
 * @package    Pizza
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Alle Listings sind urheberrechtlich geschützt!
 * @link       http://www.zendframeworkbuch.de/ und http://www.galileocomputing.de/3460
 */

/**
 * namespace definition and usage
 */
namespace Pizza\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Show pizza carousel view helper factory
 * 
 * Generates the Show pizza carousel view helper object
 * 
 * @package    Pizza
 */
class PizzaShowCarouselFactory implements FactoryInterface
{
    /**
     * Create Service Factory
     * 
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sm        = $serviceLocator->getServiceLocator();
        $pizzaList = $sm->get('Pizza\Service\Pizza')->fetchList(
            1, 20, array('status' => 'approved')
        );
        $helper    = new PizzaShowCarousel($pizzaList);
        return $helper;
    }
}
