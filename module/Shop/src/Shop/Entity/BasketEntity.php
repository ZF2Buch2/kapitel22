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
 * Shop entity
 * 
 * @package    Shop
 */
class BasketEntity implements BasketEntityInterface
{
    const VAT = 0.07;
    
    protected $positions = array();
    
    /**
     * Set positions
     * 
     * @param array $positions
     */
    public function setPositions(array $positions)
    {
        $this->positions = $positions;
    }
    
    /**
     * Get positions
     * 
     * @return array positions
     */
    public function getPositions()
    {
        return $this->positions;
    }
    
    /**
     * get position
     * 
     * @param integer $key
     * @return PositionEntity
     */
    public function getPosition($key)
    {
        if (!isset($this->positions[$key])) {
            return false;
        }
        
        return $this->positions[$key];
    }
    
    /**
     * Add position
     * 
     * @param PositionEntity $position
     */
    public function addPosition(PositionEntity $position)
    {
        if (isset($this->positions[$position->getId()])) {
            $actualPosition = $this->positions[$position->getId()];
            $actualPosition->addQuantity($position->getQuantity());
        } else {
            $this->positions[$position->getId()] = $position;
        }
    }
    
    /**
     * Remove position
     * 
     * @param PositionEntity $position
     */
    public function removePosition(PositionEntity $position)
    {
        if (!isset($this->positions[$position->getId()])) {
            return false;
        }
        
        unset($this->positions[$position->getId()]);
    }
    
    /**
     * Get total
     * 
     * @return float $total
     */
    public function getTotal()
    {
        $total = 0;
        
        foreach ($this->getPositions() as $position) {
            $total += $position->getAmount();
        }
        
        return $total;
    }
    
    /**
     * Count
     * 
     * @return integer
     */
    public function getCount()
    {
        $count = 0;
        
        foreach ($this->getPositions() as $position) {
            $count += $position->getQuantity();
        }
        
        return $count;
    }
    
    /**
     * Get vat
     * 
     * @return float $vat
     */
    public function getVat()
    {
        $total = $this->getTotal();
        
        return $total - $total / (1 + self::VAT);
    }
    
    /**
     * Is Empty
     * 
     * @return boolean
     */
    public function isEmpty()
    {
        return $this->getCount() == 0 ? true : false;
    }
}
