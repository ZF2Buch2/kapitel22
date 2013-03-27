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
namespace Shop\Table;

use Shop\Entity\OrderEntityInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Stdlib\Hydrator\HydratorInterface;

/**
 * Order table interface
 * 
 * Handles the orders table for the Shop module 
 * 
 * @package    Shop
 */
interface OrderTableInterface extends TableGatewayInterface
{
    /**
     * Constructor
     * 
     * @param Adapter $adapter database adapter
     */
    public function __construct(Adapter $adapter, OrderEntityInterface $entity, HydratorInterface $hydrator);
    
    /**
     * Fetch single order by id
     * 
     * @param integer $id id of order
     * @return OrderEntityInterface
     */
    public function fetchSingleById($id);
}
