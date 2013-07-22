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
        // pass basket to view
        return new ViewModel(array(
            'basket' => $this->getBasketService()->getBasket(),
        ));
    }
    
    /**
     * Handle remove page
     */
    public function removeAction()
    {
        // read id from route
        $id = $this->params()->fromRoute('id');
    
        // get basket
        $basket = $this->getBasketService()->getBasket();
        
        // get position
        $position = $basket->getPosition($id);
        
        // check data
        if ($position) {
            // remove from basket
            $this->getBasketService()->remove($position->getEntity());
        }
    
        // Redirect to basket
        return $this->redirect()->toRoute('shop/basket');
    }

    /**
     * Handle increase page
     */
    public function increaseAction()
    {
        // read id from route
        $id = $this->params()->fromRoute('id');
    
        // get basket
        $basket = $this->getBasketService()->getBasket();
        
        // get position
        $position = $basket->getPosition($id);
        
        // check data
        if ($position) {
            // increase position quantity
            $position->addQuantity(1);
        }
    
        // Redirect to basket
        return $this->redirect()->toRoute('shop/basket');
    }

    /**
     * Handle decrease page
     */
    public function decreaseAction()
    {
        // read id from route
        $id = $this->params()->fromRoute('id');
    
        // get basket
        $basket = $this->getBasketService()->getBasket();
    
        // get position
        $position = $basket->getPosition($id);
    
        // check data
        if ($position) {
            // decrease position quantity
            $position->subQuantity(1);
        }
    
        // Redirect to basket
        return $this->redirect()->toRoute('shop/basket');
    }
}
