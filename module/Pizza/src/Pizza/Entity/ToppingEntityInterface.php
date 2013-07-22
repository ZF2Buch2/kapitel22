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
namespace Pizza\Entity;

use Zend\Stdlib\ArraySerializableInterface;

/**
 * Topping entity interface
 * 
 * @package    Pizza
 */
interface ToppingEntityInterface extends ArraySerializableInterface
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
     * Set name
     * 
     * @param string $name
     */
    public function setName($name);
    
    /**
     * Get name
     * 
     * @return string $name
     */
    public function getName();
    
    /**
     * Set costs
     * 
     * @param float $costs
     */
    public function setCosts($costs);
    
    /**
     * Get costs
     * 
     * @return float $costs
     */
    public function getCosts();
}
