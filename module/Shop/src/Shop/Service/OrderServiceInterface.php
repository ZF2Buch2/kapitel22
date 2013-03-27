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
namespace Shop\Service;

use Zend\Db\TableGateway\TableGateway;
use Shop\Entity\OrderEntityInterface;
use Shop\Form\OrderFormInterface;
use Shop\Table\OrderTableInterface;
use User\Entity\UserEntityInterface;

/**
 * Shop Service interface
 * 
 * @package    Shop
 */
interface OrderServiceInterface
{
    /**
     * Constructor
     * 
     * @param OrderTableInterface $orderTable
     * @param UserEntityInterface $identity
     */
    public function __construct(
        OrderTableInterface $orderTable, BasketServiceInterface $basket, UserEntityInterface $identity = null
    );
    
    /**
     * Get basket service
     * 
     * @return BasketServiceInterface
     */
    public function getBasketService();
    
    /**
     * Set basket service
     * 
     * @param BasketServiceInterface $basketService
     * @return OrderServiceInterface
     */
    public function setBasketService(BasketServiceInterface $basketService);

    /**
     * Get user identity
     * 
     * @return UserEntityInterface
     */
    public function getIdentity();
    
    /**
     * Set user identity
     * 
     * @param UserEntityInterface $identity
     * @return OrderServiceInterface
     */
    public function setIdentity(UserEntityInterface $identity = null);

    /**
     * Get table with triggering the Event-Manager
     * 
     * @param  string $type table type
     * @return TableGateway
     */
    public function getTable($type = 'order');

    /**
     * Set table
     * 
     * @param TableGateway $table
     * @param string $type table type
     */
    public function setTable(TableGateway $table, $type = 'order');

    /**
     * Get service message
     * 
     * @return array
     */
    public function getMessage();
    
    /**
     * Clear service message
     */
    public function clearMessage();
    
    /**
     * Add service message
     * 
     * @param string new message
     */
    public function setMessage($message);
    
    /**
     * Get form with triggering the Event-Manager
     * 
     * @param  string $type form type
     * @return OrderFormInterface
     */
    public function getForm($type = 'create');

    /**
     * Set form
     * 
     * @param OrderFormInterface $form
     * @param string $type form type
     */
    public function setForm(OrderFormInterface $form, $type = 'create');

    /**
     * Add identity
     *
     * @param OrderEntityInterface $order
     * @return OrderEntityInterface
     */
    public function addIdentity($order);
    
    /**
     * Fetch single by id
     *
     * @param varchar $id
     * @return OrderEntityInterface
     */
    public function fetchSingleById($id);
    
    /**
     * Fetch list of orders
     *
     * @param integer $page number of page
     * @return Paginator
     */
    public function fetchList($page = 1, $perPage = 4, $params = array());
    
    /**
     * Save a order
     *
     * @param array $data input data
     * @param integer $id id of order entry
     * @return OrderEntityInterface
     */
    public function save(array $data, $id = null);
    
    /**
     * Delete existing order
     *
     * @param integer $id order id
     * @param array $data input data
     * @return OrderEntityInterface
     */
    public function delete($id);
}
