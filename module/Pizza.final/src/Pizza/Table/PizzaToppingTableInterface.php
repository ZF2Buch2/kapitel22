<?php
/**
 * ZF2 Buch Kapitel 22
 * 
 * Das Buch "Zend Framework 2 - Das Praxisbuch"
 * von Ralf Eggert ist im Galileo-Computing Verlag erschienen. 
 * ISBN 978-3-8362-2610-3
 * 
 * @package    Pizza
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Alle Listings sind urheberrechtlich geschützt!
 * @link       http://www.zendframeworkbuch.de/ und http://www.galileocomputing.de/3460
 */

/**
 * namespace definition and usage
 */
namespace Pizza\Table;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGatewayInterface;

/**
 * PizzaTopping table interface
 * 
 * Handles the pizzas_toppings table for the Pizza module 
 * 
 * @package    Pizza
 */
interface PizzaToppingTableInterface extends TableGatewayInterface
{
    /**
     * Constructor
     * 
     * @param Adapter $adapter database adapter
     */
    public function __construct(Adapter $adapter);
    
    /**
     * Save toppings for pizza
     * 
     * @param integer $pizzaId id of pizza
     * @return PizzaEntityInterface
     */
    public function savePizzaToppings($pizzaId, $currentToppings, $newToppings);
}
