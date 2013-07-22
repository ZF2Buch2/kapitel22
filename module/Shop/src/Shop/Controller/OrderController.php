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

use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Shop\Service\OrderServiceInterface;

/**
 * Shop order controller
 * 
 * Handles the order order pages
 * 
 * @package    Shop
 */
class OrderController extends AbstractActionController
{
    /**
     * @var OrderService
     */
    protected $orderService;
    
    /**
     * set the order service
     * 
     * @param OrderService
     */
    public function setOrderService(OrderServiceInterface $orderService)
    {
        $this->orderService = $orderService;

        return $this;
    }
    
    /**
     * Get the order service
     * 
     * @return OrderServiceInterface
     */
    public function getOrderService()
    {
        return $this->orderService;
    }
    
    /**
     * Handle admin page
     */
    public function indexAction()
    {
        // read page from route
        $page = (int) $this->params()->fromRoute('page');
        
        // set max order per page
        $maxPage = 10;
        
        // read data and pass to view
        return new ViewModel(array(
            'orderList' => $this->getOrderService()->fetchList($page, $maxPage),
        ));
    }
    
    /**
     * Handle create page
     */
    public function createAction()
    {
        // prepare Post/Redirect/Get Plugin
        $prg = $this->prg(
            $this->url()->fromRoute(
                'shop/order/action', array('action' => 'create')
            ), 
            true
        );

        // check PRG plugin for redirect to send
        if ($prg instanceof Response) {
            return $prg;
            
        // check PRG for redirect to process
        } elseif ($prg !== false) {
            // check for cancel
            if (isset($prg['cancel'])) {
                // Redirect to list of orders
                return $this->redirect()->toRoute('shop/basket');
            }
            
            // create with redirected data
            $order = $this->getOrderService()->save($prg);
            
            // check order
            if ($order) {
                // add messages to flash messenger
                $this->flashMessenger()->addMessage(
                    $this->getOrderService()->getMessage()
                );
                
                // clear basket
                $this->getOrderService()->getBasketService()->initBasket();
                
                // Redirect to home page
                return $this->redirect()->toRoute(
                    'shop/order/action', 
                    array('action' => 'thanks', 'id' => $order->getId())
                );
            }
        }
        
        // get form
        $form = $this->getOrderService()->getForm('create');
        
        // add messages to flash messenger
        if ($this->getOrderService()->getMessage()) {
            $this->flashMessenger()->addMessage(
                $this->getOrderService()->getMessage()
            );
        }
        
        // no post or registration unsuccesful
        return new ViewModel(array(
            'form'     => $form,
            'identity' => $this->getOrderService()->getIdentity(),
        ));
    }
    
    /**
     * Handle thanks page
     */
    public function thanksAction()
    {
        // read id from route and check
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('shop');
        }
        
        // get order
        $order = $this->getOrderService()->fetchSingleById($id);
        
        // check order
        if ($order === false) {
            return $this->redirect()->toRoute('shop');
        }
        
        // check user
        if ($this->getOrderService()->getIdentity()->getId() != $order->getUserId()) {
            return $this->redirect()->toRoute('shop');
        }
        
        // no post or update unsuccesful
        return new ViewModel(array(
            'order' => $order,
        ));
    }
    
    /**
     * Handle update page
     */
    public function updateAction()
    {
        // read id from route and check
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('shop/order');
        }
        
        // prepare Post/Redirect/Get Plugin
        $prg = $this->prg(
            $this->url()->fromRoute('shop/order/action', array(), array(), true), 
            true
        );
        
        // check PRG plugin for redirect to send
        if ($prg instanceof Response) {
            return $prg;
            
        // check PRG for redirect to process
        } elseif ($prg !== false) {
            
            // check for cancel
            if (isset($prg['cancel'])) {
                // Redirect to list of orders
                return $this->redirect()->toRoute('shop/order');
            }
            
            // update with redirected data
            $order = $this->getOrderService()->save($prg, $id);
            
            // check order
            if ($order) {
                // add messages to flash messenger
                $this->flashMessenger()->addMessage(
                    $this->getOrderService()->getMessage()
                );
                
                // Redirect to update order
                return $this->redirect()->toRoute(
                    'shop/order/action', array(), array(), true
                );
            }
        }
        
        // get order
        $order = $this->getOrderService()->fetchSingleById($id);
        
        // check order
        if ($order === false) {
            return $this->redirect()->toRoute('shop/order');
        }
        
        // get form and bind object
        $form = $this->getOrderService()->getForm('update');
        
        //check prg
        if ($prg === false) {
            $form->bind($order);
        }
        
        // add messages to flash messenger
        if ($this->getOrderService()->getMessage()) {
            $this->flashMessenger()->addMessage(
                $this->getOrderService()->getMessage()
            );
        }
        
        // no post or update unsuccesful
        return new ViewModel(array(
            'form' => $form,
            'order' => $order,
        ));
    }
    
    /**
     * Handle delete page
     */
    public function deleteAction()
    {
        // read id from route and check
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('shop/order');
        }
        
        // prepare Post/Redirect/Get Plugin
        $prg = $this->prg(
            $this->url()->fromRoute('shop/order/action', array(), array(), true), 
            true
        );
        
        // check PRG plugin for redirect to send
        if ($prg instanceof Response) {
            return $prg;
            
        // check PRG for redirect to process
        } elseif ($prg !== false) {
            // check for cancel
            if (isset($prg['cancel'])) {
                // Redirect to list of orders
                return $this->redirect()->toRoute('shop/order');
            }
            
            // delete with redirected data
            $order = $this->getOrderService()->delete($id);
            
            // check order
            if ($order) {
                // add messages to flash messenger
                $this->flashMessenger()->addMessage(
                    $this->getOrderService()->getMessage()
                );
                
                // Redirect to list of order
                return $this->redirect()->toRoute('shop/order');
            }
        }
        
        // get order
        $order = $this->getOrderService()->fetchSingleById($id);
        
        // check order
        if ($order === false) {
            return $this->redirect()->toRoute('shop/order');
        }
        
        // get form and bind object
        $form = $this->getOrderService()->getForm('delete');
        
        //check prg
        if ($prg === false) {
            $form->bind($order);
        }
        
        // add messages to flash messenger
        if ($this->getOrderService()->getMessage()) {
            $this->flashMessenger()->addMessage(
                $this->getOrderService()->getMessage()
            );
        }
        
        // no post or update unsuccesful
        return new ViewModel(array(
            'form' => $form,
            'order' => $order,
        ));
    }
}
