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
namespace Shop\Entity;

use Zend\Stdlib\ArraySerializableInterface;

/**
 * Position entity interface
 * 
 * @package    Shop
 */
interface PositionEntityInterface extends ArraySerializableInterface
{
    /**
     * Set id
     * 
     * @param integer $id
     */
    public function setId($id);
    
    /**
     * Get id
     * 
     * @return integer $id
     */
    public function getId();
    
    /**
     * Set quantity
     * 
     * @param integer $quantity
     */
    public function setQuantity($quantity);
    
    /**
     * Add quantity
     * 
     * @param integer $quantity
     */
    public function addQuantity($quantity = 1);
    
    /**
     * Sub quantity
     * 
     * @param integer $quantity
     */
    public function subQuantity($quantity);
    
    /**
     * Get quantity
     * 
     * @return integer $quantity
     */
    public function getQuantity();
    
    /**
     * Get amount
     * 
     * @return float $amount
     */
    public function getAmount();
    
    /**
     * Set entity
     * 
     * @param object $entity
     */
    public function setEntity($entity);
    
    /**
     * Get entity
     * 
     * @return object $entity
     */
    public function getEntity();
}
