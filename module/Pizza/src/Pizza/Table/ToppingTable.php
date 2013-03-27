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
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

/**
 * Topping table
 * 
 * Handles the toppings table for the Pizza module 
 * 
 * @package    Pizza
 */
class ToppingTable extends TableGateway
{
    /**
     * Constructor
     * 
     * @param Adapter $adapter database adapter
     */
    public function __construct(Adapter $adapter, ToppingEntityInterface $entity)
    {
        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype($entity);
        
        parent::__construct('toppings', $adapter, null, $resultSet);
    }
    
    /**
     * Fetch options
     * 
     * @return array
     */
    public function fetchOptions()
    {
        $select = $this->getSql()->select();
        $select->order('id');
        
        $options = array();
        
        foreach ($this->selectWith($select) as $row) {
            $options[$row->getId()] = $row->getName();
        }
        
        return $options;
    }
    
    /**
     * Fetch list
     * 
     * @param integer $pizzaId id of pizza
     * @return ToppingEntity[]
     */
    public function fetchListByPizzaId($pizzaId)
    {
        $select = $this->getSql()->select();
        $select->join('pizzas_toppings', 'topping_id = id', array());
        $select->where->equalTo('pizza_id', $pizzaId);
        $select->order('id');

        $list = array();
        
        foreach ($this->selectWith($select) as $row) {
            $list[$row->getId()] = $row;
        }
        
        return $list;
    }
    
    /**
     * Fetch single crust by id
     * 
     * @param integer $id id ofcrust
     * @return ToppingEntity
     */
    public function fetchSingleById($id)
    {
        $select = $this->getSql()->select();
        $select->where->equalTo('id', $id);
        
        return $this->selectWith($select)->current();
    }
}
