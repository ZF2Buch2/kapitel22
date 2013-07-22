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
namespace Shop\Service;

use Zend\Db\Adapter\Exception\InvalidQueryException;
use Zend\Db\TableGateway\TableGateway;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect;
use Shop\Entity\OrderEntityInterface;
use Shop\Entity\OrderEntity;
use Shop\Form\OrderFormInterface;
use Shop\Table\OrderTableInterface;
use User\Entity\UserEntityInterface;

/**
 * Shop Service
 * 
 * @package    Shop
 */
class OrderService implements EventManagerAwareInterface, OrderServiceInterface
{
    /**
     * @var EventManagerInterface
     */
    protected $eventManager = null;
    
    /**
     * @var BasketServiceInterface
     */
    protected $basketService = null;
    
    /**
     * @var OrderFormInterface[]
     */
    protected $forms = array();

    /**
     * @var OrderTableInterface
     */
    protected $tables = array();

    /**
     * @var UserEntityInterface
     */
    protected $identity = null;
    
    /**
     * @var string
     */
    protected $message = null;
    
    /**
     * Constructor
     * 
     * @param OrderTableInterface $orderTable
     * @param UserEntityInterface $identity
     */
    public function __construct(
        OrderTableInterface $orderTable, BasketServiceInterface $basket, UserEntityInterface $identity = null
    )
    {
        $this->setTable($orderTable, 'order');
        $this->setBasketService($basket);
        $this->setIdentity($identity);
    }
    
    /**
     * Inject an EventManager instance
     *
     * @param  EventManagerInterface $eventManager
     * @return void
     */
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $eventManager->setIdentifiers(array(__CLASS__));
        $this->eventManager = $eventManager;
    }
    
    /**
     * Retrieve the event manager
     *
     * Lazy-loads an EventManager instance if none registered.
     *
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
        return $this->eventManager;
    }
    
    /**
     * Get basket service
     * 
     * @return BasketServiceInterface
     */
    public function getBasketService()
    {
        return $this->basketService;
    }
    
    /**
     * Set basket service
     * 
     * @param BasketServiceInterface $basketService
     * @return OrderServiceInterface
     */
    public function setBasketService(BasketServiceInterface $basketService)
    {
        $this->basketService = $basketService;
        return $this;
    }

    /**
     * Get user identity
     * 
     * @return UserEntityInterface
     */
    public function getIdentity()
    {
        return $this->identity;
    }
    
    /**
     * Set user identity
     * 
     * @param UserEntityInterface $identity
     * @return OrderServiceInterface
     */
    public function setIdentity(UserEntityInterface $identity = null)
    {
        $this->identity = $identity;
        return $this;
    }

    /**
     * Get table with triggering the Event-Manager
     * 
     * @param  string $type table type
     * @return TableGateway
     */
    public function getTable($type = 'order')
    {
        if (!isset($this->tables[$type])) {
            $this->getEventManager()->trigger(
                'set-order-table', __CLASS__, array('type' => $type)
            );
        }
        
        return $this->tables[$type];
    }

    /**
     * Set table
     * 
     * @param TableGateway $table
     * @param string $type table type
     */
    public function setTable(TableGateway $table, $type = 'order')
    {
        $this->tables[$type] = $table;
    }

    /**
     * Get service message
     * 
     * @return array
     */
    public function getMessage()
    {
        return $this->message;
    }
    
    /**
     * Clear service message
     */
    public function clearMessage()
    {
        $this->message = null;
    }
    
    /**
     * Add service message
     * 
     * @param string new message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }
    
    /**
     * Get form with triggering the Event-Manager
     * 
     * @param  string $type form type
     * @return OrderFormInterface
     */
    public function getForm($type = 'create')
    {
        if (!isset($this->forms[$type])) {
            $this->getEventManager()->trigger(
                'set-order-form', __CLASS__, array('type' => $type)
            );
        }
        
        return $this->forms[$type];
    }

    /**
     * Set form
     * 
     * @param OrderFormInterface $form
     * @param string $type form type
     */
    public function setForm(OrderFormInterface $form, $type = 'create')
    {
        $this->forms[$type] = $form;
    }

    /**
     * Add identity
     *
     * @param OrderEntityInterface $order
     * @return OrderEntityInterface
     */
    public function addIdentity($order)
    {
        if (!$order) {
            return false;
        }
        
        $order->setIdentity(
            $this->getTable('user')->fetchSingleById($order->getUserId())
        );
        
        return $order;
    }
    
    /**
     * Fetch single by id
     *
     * @param varchar $id
     * @return OrderEntityInterface
     */
    public function fetchSingleById($id)
    {
        $order = $this->getTable('order')->fetchSingleById($id);
        $order = $this->addIdentity($order);
        return $order;
    }
    
    /**
     * Fetch list of orders
     *
     * @param integer $page number of page
     * @return Paginator
     */
    public function fetchList($page = 1, $perPage = 4, $params = array())
    {
        // Initialize select
        $select = $this->getTable('order')->getSql()->select();
        $select->columns(array('id'));
        $select->order('cdate DESC');
        
        // loop through params
        foreach ($params as $param => $value) {
            $select->where->equalTo($param, $value);
        }
        
        // Initialize paginator
        $adapter = new DbSelect(
            $select, 
            $this->getTable('order')->getAdapter()
        );
        $paginator = new Paginator($adapter);
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage($perPage);
        $paginator->setPageRange(9);
        
        // return paginator
        return $paginator;
    }
    
    /**
     * Save a order
     *
     * @param array $data input data
     * @param integer $id id of blog entry
     * @return OrderEntityInterface
     */
    public function save(array $data, $id = null)
    {
        // check mode
        $mode = is_null($id) ? 'create' : 'update';
        
        // get order entity
        if ($mode == 'create') {
            $order = new OrderEntity();
        } else {
            $order = $this->fetchSingleById($id);
        }
        
        // get form and set data
        $form = $this->getForm($mode);
        $form->setData($data);
        
        // check for invalid data
        if (!$form->isValid()) {
            $this->setMessage('Bitte Eingaben überprüfen!');
            return false;
        }
        
        // get valid order entity object
        $order->exchangeArray($form->getData());
        
        // set values
        if ($mode == 'create') {
            $order->setCdate(date('Y-m-d H:i:s'));
            $order->setStatus('new');
            $order->setPositions($this->getBasketService()->getBasket());
            $order->setUserId($this->getIdentity()->getId());
        }
        
        // get hydrator
        $hydrator = $this->getTable('order')->getResultSetPrototype()->getHydrator();
        
        // get insert data
        $saveData = $hydrator->extract($order);
        
        // insert new order
        try {
            if ($mode == 'create') {
                $this->getTable('order')->insert($saveData);
                
                // get last insert value
                $id = $this->getTable('order')->getLastInsertValue();
            } else {
                $this->getTable('order')->update($saveData, array('id' => $id));
            }
        } catch (InvalidQueryException $e) {
            $this->setMessage('Bestellung konnte nicht gespeichert werden!');
            return false;
        }

        // reload order
        $order = $this->fetchSingleById($id);
        
        // set success message
        $this->setMessage('Die Bestellung wurde gespeichert!');
        
        // return order
        return $order;
    }
    
    /**
     * Delete existing order
     *
     * @param integer $id order id
     * @param array $data input data
     * @return OrderEntityInterface
     */
    public function delete($id)
    {
        // fetch order entity
        $order = $this->fetchSingleById($id);
        
        // delete existing order
        try {
            $result = $this->getTable('order')->delete(array('id' => $id));
        } catch (InvalidQueryException $e) {
            return false;
        }

        // set success message
        $this->setMessage('Die Bestellung wurde gelöscht!');
        
        // return result
        return true;
    }
}
