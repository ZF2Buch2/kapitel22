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
namespace Pizza\Table;

use Pizza\Entity\ToppingEntityInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGatewayInterface;

/**
 * Topping table interface
 * 
 * Handles the toppings table for the Pizza module 
 * 
 * @package    Pizza
 */
interface ToppingTableInterface extends TableGatewayInterface
{
    /**
     * Constructor
     * 
     * @param Adapter $adapter database adapter
     */
    public function __construct(Adapter $adapter, ToppingEntityInterface $entity);
    
    /**
     * Fetch options
     * 
     * @return array
     */
    public function fetchOptions();
    
    /**
     * Fetch list
     * 
     * @param integer $pizzaId id of pizza
     * @return ToppingEntity[]
     */
    public function fetchListByPizzaId($pizzaId);
    
    /**
     * Fetch single crust by id
     * 
     * @param integer $id id ofcrust
     * @return ToppingEntity
     */
    public function fetchSingleById($id);
}
