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
namespace Shop\Service;

use Shop\Entity\BasketEntityInterface;
use Shop\Entity\BasketEntity;
use Shop\Entity\PositionEntity;
use Zend\Session\Container;

/**
 * Basket Service
 * 
 * @package    Shop
 */
class BasketService implements BasketServiceInterface
{
    /**
     * Default session namespace
     */
    const NAMESPACE_DEFAULT = 'Basket_Session';
    
    /**
     * @var Container
     */
    protected $session = null;

    /**
     * @var string
     */
    protected $message = null;
    
    /**
     * Constructor
     * 
     * @param ShopTable $shopTable
     */
    public function __construct()
    {
        $this->session = new Container(self::NAMESPACE_DEFAULT);
    }
    
    /**
     * Init basket
     * 
     * @return BasketServiceInterface
     */
    public function initBasket()
    {
        $this->setBasket(new BasketEntity());

        return $this;
    }

    /**
     * Get basket
     * 
     * @return BasketEntityInterface
     */
    public function getBasket()
    {
        if (!$this->session->basket) {
            $this->initBasket();
        }
        
        return $this->session->basket;
    }

    /**
     * Set basket
     * 
     * @param BasketEntityInterface
     * @return BasketServiceInterface
     */
    public function setBasket(BasketEntityInterface $basket)
    {
        $this->session->basket = $basket;
        
        return $this;
    }

    /**
     * Get service message
     * 
     * @return array
     */
    public function getMessage()
    {
        return $this->message;
    }
    
    /**
     * Clear service message
     */
    public function clearMessage()
    {
        $this->message = null;
    }
    
    /**
     * Add service message
     * 
     * @param string new message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }
    
    /**
     * Add to basket
     *
     * @param object $entity entity to be added
     * @return BasketServiceInterface
     */
    public function add($entity)
    {
        // build position 
        $position = new PositionEntity();
        $position->setId($entity->getId());
        $position->setQuantity(1);
        $position->setEntity($entity);
        
        // add to basket
        $basket = $this->getBasket();
        $basket->addPosition($position);
        
        // set success message
        $this->setMessage('Der Artikel wurde in den Warenkorb gelegt!');
        
        // return service
        return $this;
    }
    
    /**
     * Remove from basket
     *
     * @param object $entity entity to be added
     * @return BasketServiceInterface
     */
    public function remove($entity)
    {
        // build position 
        $position = new PositionEntity();
        $position->setId($entity->getId());
        $position->setQuantity(0);
        $position->setEntity($entity);
        
        // remove from basket
        $basket = $this->getBasket();
        $basket->removePosition($position);
        
        // set success message
        $this->setMessage('Der Artikel wurde aus dem Warenkorb entfernt!');
        
        // return service
        return $this;
    }
}
