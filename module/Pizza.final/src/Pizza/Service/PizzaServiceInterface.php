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
namespace Pizza\Service;

use Zend\Db\TableGateway\TableGateway;
use Pizza\Entity\PizzaEntityInterface;
use Pizza\Form\PizzaFormInterface;
use Pizza\Table\PizzaTableInterface;

/**
 * Pizza Service interface
 * 
 * @package    Pizza
 */
interface PizzaServiceInterface
{
    /**
     * Constructor
     * 
     * @param PizzaTableInterface $pizzaTable
     */
    public function __construct(PizzaTableInterface $pizzaTable);
    
    /**
     * Get table with triggering the Event-Manager
     * 
     * @param  string $type table type
     * @return TableGateway
     */
    public function getTable($type = 'pizza');

    /**
     * Set table
     * 
     * @param TableGateway $table
     * @param string $type table type
     */
    public function setTable(TableGateway $table, $type = 'pizza');

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
     * @return PizzaFormInterface
     */
    public function getForm($type = 'create');

    /**
     * Set form
     * 
     * @param PizzaFormInterface $form
     * @param string $type form type
     */
    public function setForm(PizzaFormInterface $form, $type = 'create');

    /**
     * Add crust and toppings
     *
     * @param PizzaEntityInterface $pizza
     * @return PizzaEntityInterface
     */
    public function addCrustAndToppings($pizza);
    
    /**
     * Fetch single by url
     *
     * @param varchar $url
     * @return PizzaEntityInterface
     */
    public function fetchSingleByUrl($url);
    
    /**
     * Fetch single by id
     *
     * @param varchar $id
     * @return PizzaEntityInterface
     */
    public function fetchSingleById($id);
    
    /**
     * Fetch list of pizzas
     *
     * @param integer $page number of page
     * @return Paginator
     */
    public function fetchList($page = 1, $perPage = 4, $params = array());
    
    /**
     * Save a pizza
     *
     * @param array $data input data
     * @param integer $id id of pizza entry
     * @return PizzaEntityInterface
     */
    public function save(array $data, $id = null);
    
    /**
     * Delete existing pizza
     *
     * @param integer $id pizza id
     * @param array $data input data
     * @return PizzaEntityInterface
     */
    public function delete($id);
}
