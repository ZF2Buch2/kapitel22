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
namespace Shop\Entity;

/**
 * Shop entity interface
 * 
 * @package    Shop
 */
interface BasketEntityInterface
{
    /**
     * Set positions
     * 
     * @param array $positions
     */
    public function setPositions(array $positions);
    
    /**
     * Get positions
     * 
     * @return array positions
     */
    public function getPositions();
    
    /**
     * get position
     * 
     * @param integer $key
     * @return PositionEntity
     */
    public function getPosition($key);
    
    /**
     * Add position
     * 
     * @param PositionEntity $position
     */
    public function addPosition(PositionEntity $position);
    
    /**
     * Remove position
     * 
     * @param PositionEntity $position
     */
    public function removePosition(PositionEntity $position);
    
    /**
     * Get total
     * 
     * @return float $total
     */
    public function getTotal();
    
    /**
     * Count
     * 
     * @return integer
     */
    public function getCount();
    
    /**
     * Is Empty
     * 
     * @return boolean
     */
    public function isEmpty();
}
