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

use Pizza\Entity\PizzaEntityInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGatewayInterface;

/**
 * Pizza table interface
 * 
 * Handles the pizzas table for the Pizza module 
 * 
 * @package    Pizza
 */
interface PizzaTableInterface extends TableGatewayInterface
{
    /**
     * Constructor
     * 
     * @param Adapter $adapter database adapter
     */
    public function __construct(Adapter $adapter, PizzaEntityInterface $entity);
    
    /**
     * Fetch single pizza by url
     * 
     * @param varchar $url url address of pizza
     * @return PizzaEntityInterface
     */
    public function fetchSingleByUrl($url);
    
    /**
     * Fetch single pizza by id
     * 
     * @param integer $id id of pizza
     * @return PizzaEntityInterface
     */
    public function fetchSingleById($id);
}
