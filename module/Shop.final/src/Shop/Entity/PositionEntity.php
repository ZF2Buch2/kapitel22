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

/**
 * Position entity
 * 
 * @package    Shop
 */
class PositionEntity implements PositionEntityInterface
{
    protected $id       = null;
    protected $quantity = null;
    protected $entity   = null;
    
    /**
     * Set id
     * 
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * Get id
     * 
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set quantity
     * 
     * @param integer $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }
    
    /**
     * Add quantity
     * 
     * @param integer $quantity
     */
    public function addQuantity($quantity = 1)
    {
        $this->quantity += $quantity;
    }
    
    /**
     * Sub quantity
     * 
     * @param integer $quantity
     */
    public function subQuantity($quantity)
    {
        if ($this->quantity >= $quantity) {
            $this->quantity -= $quantity;
        }
    }
    
    /**
     * Get quantity
     * 
     * @return integer $quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
    
    /**
     * Get amount
     * 
     * @return float $amount
     */
    public function getAmount()
    {
        return $this->quantity * $this->getEntity()->getPrice();
    }
    
    /**
     * Set entity
     * 
     * @param object $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }
    
    /**
     * Get entity
     * 
     * @return object $entity
     */
    public function getEntity()
    {
        return $this->entity;
    }
    
    /**
     * Exchange internal values from provquantityed array
     *
     * @param  array $array
     * @return voquantity
     */
    public function exchangeArray(array $array)
    {
        foreach ($array as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $method = 'set' . StaticFilter::execute(
                $key, 'wordunderscoretocamelcase'
            );
            if (!method_exists($this, $method)) {
                continue;
            }
            $this->$method($value);
        }
    }

    /**
     * Return an array representation of the object
     *
     * @return array
     */
    public function getArrayCopy()
    {
        return array(
            'id'       => $this->getId(),
            'quantity' => $this->getQuantity(),
            'entity'   => $this->getEntity(),
        );
    }
}
