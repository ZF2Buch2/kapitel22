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

/**
 * Pizza entity
 * 
 * @package    Pizza
 */
class PizzaEntity implements PizzaEntityInterface
{
    protected $statusNames = array(
        'blocked'  => 'gesperrt',
        'approved' => 'genehmigt',
    );
    
    protected $id;
    protected $status;
    protected $name;
    protected $description;
    protected $price;
    protected $url;
    protected $crustId;
    protected $crustEntity;
    protected $toppings = array();
    
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
     * Set status
     * 
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
    
    /**
     * Get status
     * 
     * @return string $status
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * Get status name
     * 
     * @return string $status
     */
    public function getStatusName()
    {
        return $this->statusNames[$this->status];
    }
    
    /**
     * Get status names
     * 
     * @return array list of stati
     */
    public function getStatusNames()
    {
        return $this->statusNames;
    }
    
    /**
     * Set name
     * 
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * Get name
     * 
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Set description
     * 
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
    
    /**
     * Get description
     * 
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * Set price
     * 
     * @param string $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }
    
    /**
     * Get price
     * 
     * @return string $price
     */
    public function getPrice()
    {
        return $this->price;
    }
    
    /**
     * Set url
     * 
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }
    
    /**
     * Get url
     * 
     * @return string $url
     */
    public function getUrl()
    {
        return $this->url;
    }
    
    /**
     * Set crustId
     * 
     * @param string $crustId
     */
    public function setCrustId($crustId)
    {
        $this->crustId = $crustId;
    }
    
    /**
     * Get crustId
     * 
     * @return string $crustId
     */
    public function getCrustId()
    {
        return $this->crustId;
    }
    
    /**
     * Set crustEntity
     * 
     * @param CrustEntityInterface $crustEntity
     */
    public function setCrustEntity(CrustEntityInterface $crustEntity)
    {
        $this->crustEntity = $crustEntity;
    }
    
    /**
     * Get crustEntity
     * 
     * @return CrustEntityInterface $crustEntity
     */
    public function getCrustEntity()
    {
        return $this->crustEntity;
    }
    
    /**
     * Set toppings
     * 
     * @param array $toppings
     */
    public function setToppings(array $toppings)
    {
        $this->toppings = $toppings;
    }
    
    /**
     * Get toppings
     * 
     * @return array toppings
     */
    public function getToppings()
    {
        return $this->toppings;
    }
    
    /**
     * Exchange internal values from provided array
     *
     * @param  array $array
     * @return void
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
            'id'          => $this->getId(),
            'status'      => $this->getStatus(),
            'name'        => $this->getName(),
            'description' => $this->getDescription(),
            'price'       => $this->getPrice(),
            'url'         => $this->getUrl(),
            'crust_id'    => $this->getCrustId(),
        );
    }
}
