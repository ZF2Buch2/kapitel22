<?php
/**
 * ZF2 Buch Kapitel 22
 * 
 * Das Buch "Zend Framework 2 - Von den Grundlagen bis zur fertigen Anwendung"
 * von Ralf Eggert ist im Addison-Wesley Verlag erschienen. 
 * ISBN 978-3-8273-2994-3
 * 
 * @package    Shop
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Alle Listings sind urheberrechtlich geschützt!
 * @link       http://www.zendframeworkbuch.de/ und http://www.awl.de/2994
 */

/**
 * namespace definition and usage
 */
namespace Shop\Controller\Plugin;

use Shop\Service\BasketServiceInterface;
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
        // return plugin
        return $this;
    }
    
    /**
     * Add position to basket
     * 
     * @param object $position position to be added
     */
    public function add($position)
    {
        return $this->getBasketService()->add($position);
    }
    
    /**
     * Remove position from basket
     * 
     * @param integer $key position key
     */
    public function remove($key)
    {
        return $this->getBasketService()->remove($key);
    }
}
