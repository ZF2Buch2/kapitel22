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
namespace Shop\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Shop\Service\BasketServiceInterface;

/**
 * Shop basket controller
 * 
 * Handles the shop basket pages
 * 
 * @package    Shop
 */
class BasketController extends AbstractActionController
{
    /**
     * @var BasketServiceInterface
     */
    protected $basketService;
    
    /**
     * set the shop service
     * 
     * @param BasketService
     */
    public function setBasketService(BasketServiceInterface $basketService)
    {
        $this->basketService = $basketService;

        return $this;
    }
    
    /**
     * Get the shop service
     * 
     * @return BasketServiceInterface
     */
    public function getBasketService()
    {
        return $this->basketService;
    }
    
    /**
     * Handle basket page
     */
    public function indexAction()
    {
    }
    
    /**
     * Handle remove page
     */
    public function removeAction()
    {
    }

    /**
     * Handle increase page
     */
    public function increaseAction()
    {
    }

    /**
     * Handle decrease page
     */
    public function decreaseAction()
    {
    }
}
