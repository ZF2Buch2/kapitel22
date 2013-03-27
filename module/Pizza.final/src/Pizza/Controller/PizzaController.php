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
namespace Pizza\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use Pizza\Service\PizzaServiceInterface;

/**
 * Pizza controller
 * 
 * Handles the pizza pages
 * 
 * @package    Pizza
 */
class PizzaController extends AbstractActionController
{
    /**
     * @var PizzaServiceInterface
     */
    protected $pizzaService;
    
    /**
     * set the pizza service
     * 
     * @param PizzaServiceInterface
     */
    public function setPizzaService(PizzaServiceInterface $pizzaService)
    {
        $this->pizzaService = $pizzaService;

        return $this;
    }
    
    /**
     * Get the pizza service
     * 
     * @return PizzaServiceInterface
     */
    public function getPizzaService()
    {
        return $this->pizzaService;
    }
    
    /**
     * Handle pizza page
     */
    public function indexAction()
    {
        // read page from route
        $page = (int) $this->params()->fromRoute('page');
        
        // set max pizza per page
        $maxPage = 3;
        
        // read data and pass to view
        return new ViewModel(array(
            'pizzaList' => $this->getPizzaService()->fetchList(
                $page, $maxPage, array('status' => 'approved')
            ),
        ));
    }
    
    /**
     * Handle show page
     */
    public function showAction()
    {
        // read url from route
        $url = $this->params()->fromRoute('url');
        
        // fetch data
        $pizzaData = $this->getPizzaService()->fetchSingleByUrl($url);
        
        // check data
        if (!$pizzaData) {
            // Redirect to pizza page
            return $this->redirect()->toRoute('pizza');
        }
        
        // read data and pass to view
        return new ViewModel(array(
            'pizzaData' => $pizzaData,
        ));
    }
    
    /**
     * Handle basket page
     */
    public function basketAction()
    {
        // read id from route
        $id = $this->params()->fromRoute('id');
        
        // fetch data
        $pizzaData = $this->getPizzaService()->fetchSingleById($id);
        
        // check data
        if (!$pizzaData) {
            // Redirect to pizza page
            return $this->redirect()->toRoute('pizza');
        }
        
        // add to basket
        $this->shopBasket()->add($pizzaData);
        
        // Redirect to home
        return $this->redirect()->toRoute(
            'pizza/url', array('url' => $pizzaData->getUrl())
        );
    }
}
