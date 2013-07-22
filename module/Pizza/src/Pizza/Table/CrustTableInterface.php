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

use Pizza\Entity\CrustEntityInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGatewayInterface;

/**
 * Crust table interface
 * 
 * Handles the crusts table for the Pizza module 
 * 
 * @package    Pizza
 */
interface CrustTableInterface extends TableGatewayInterface
{
    /**
     * Constructor
     * 
     * @param Adapter $adapter database adapter
     */
    public function __construct(Adapter $adapter, CrustEntityInterface $entity);
    
    /**
     * Fetch options
     * 
     * @return array
     */
    public function fetchOptions();
    
    /**
     * Fetch single crust by id
     * 
     * @param integer $id id ofcrust
     * @return CrustEntity
     */
    public function fetchSingleById($id);
}
