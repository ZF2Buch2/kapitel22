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
namespace Shop\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

/**
 * Provides access to the BasketService
 * 
 * @package    Shop
 */
class Basket extends AbstractPlugin
{
    /**
     * @var BasketServiceInterface
     */
    protected $basketService;

    /**
     * Constructor
     *
     * @param  BasketServiceInterface $basketService
     */
    public function __construct(BasketServiceInterface $basketService)
    {
        $this->setBasketService($basketService);
    }

    /**
     * Sets shop basketService
     *
     * @param  BasketServiceInterface $basketService
     * @return AbstractHelper
     */
    public function setBasketService(BasketServiceInterface $basketService = null)
    {
        $this->basketService = $basketService;
        return $this;
    }
    
    /**
     * Returns BasketService
     *
     * @return BasketServiceInterface
     */
    public function getBasketService()
    {
        return $this->basketService;
    }
    
    /**
     * Returns itself
     *
     * @return Shop 
     */
    public function __invoke()
    {
    }
}
