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

use Zend\Filter\StaticFilter;
use Zend\Stdlib\ArraySerializableInterface;

/**
 * Pizza entity interface
 * 
 * @package    Pizza
 */
interface PizzaEntityInterface extends ArraySerializableInterface
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
     * Set status
     * 
     * @param string $status
     */
    public function setStatus($status);
    
    /**
     * Get status
     * 
     * @return string $status
     */
    public function getStatus();
    
    /**
     * Get status name
     * 
     * @return string $status
     */
    public function getStatusName();
    
    /**
     * Get status names
     * 
     * @return array list of stati
     */
    public function getStatusNames();
    
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
     * Set description
     * 
     * @param string $description
     */
    public function setDescription($description);
    
    /**
     * Get description
     * 
     * @return string $description
     */
    public function getDescription();
    
    /**
     * Set price
     * 
     * @param string $price
     */
    public function setPrice($price);
    
    /**
     * Get price
     * 
     * @return string $price
     */
    public function getPrice();
    
    /**
     * Set url
     * 
     * @param string $url
     */
    public function setUrl($url);
    
    /**
     * Get url
     * 
     * @return string $url
     */
    public function getUrl();
    
    /**
     * Set crustId
     * 
     * @param string $crustId
     */
    public function setCrustId($crustId);
    
    /**
     * Get crustId
     * 
     * @return string $crustId
     */
    public function getCrustId();
    
    /**
     * Set crustEntity
     * 
     * @param CrustEntityInterface $crustEntity
     */
    public function setCrustEntity(CrustEntityInterface $crustEntity);
    
    /**
     * Get crustEntity
     * 
     * @return CrustEntityInterface $crustEntity
     */
    public function getCrustEntity();
    
    /**
     * Set toppings
     * 
     * @param array $toppings
     */
    public function setToppings(array $toppings);
    
    /**
     * Get toppings
     * 
     * @return array toppings
     */
    public function getToppings();
}
