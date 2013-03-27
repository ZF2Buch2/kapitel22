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
 * Basket Service interface
 * 
 * @package    Shop
 */
interface BasketServiceInterface
{
    /**
     * Constructor
     * 
     * @param ShopTable $shopTable
     */
    public function __construct();
    
    /**
     * Init basket
     * 
     * @return BasketServiceInterface
     */
    public function initBasket();

    /**
     * Get basket
     * 
     * @return BasketEntityInterface
     */
    public function getBasket();

    /**
     * Set basket
     * 
     * @param BasketEntityInterface
     * @return BasketServiceInterface
     */
    public function setBasket(BasketEntityInterface $basket);

    /**
     * Get service message
     * 
     * @return array
     */
    public function getMessage();
    
    /**
     * Clear service message
     */
    public function clearMessage();
    
    /**
     * Add service message
     * 
     * @param string new message
     */
    public function setMessage($message);
    
    /**
     * Add to basket
     *
     * @param object $entity entity to be added
     * @return BasketServiceInterface
     */
    public function add($entity);
    
    /**
     * Remove from basket
     *
     * @param object $entity entity to be added
     * @return BasketServiceInterface
     */
    public function remove($entity);
}
