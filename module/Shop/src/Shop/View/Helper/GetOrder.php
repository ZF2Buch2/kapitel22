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
namespace Shop\View\Helper;

use Shop\Entity\OrderEntityInterface;
use Shop\Service\OrderServiceInterface;
use Zend\View\Helper\AbstractHelper;

/**
 * GetOrder view helper
 * 
 * @package    Shop
 */
class GetOrder extends AbstractHelper
{
    /**
     * @var OrderService
     */
    protected $orderService;

    /**
     * Constructor
     *
     * @param  OrderServiceInterface $orderService
     */
    public function __construct(OrderServiceInterface $orderService)
    {
        $this->setOrderService($orderService);
    }

    /**
     * Sets shop orderService
     *
     * @param  OrderServiceInterface $orderService
     * @return AbstractHelper
     */
    public function setOrderService(OrderServiceInterface $orderService = null)
    {
        $this->orderService = $orderService;
        return $this;
    }
    
    /**
     * Returns OrderService
     *
     * @return OrderServiceInterface
     */
    public function getOrderService()
    {
        return $this->orderService;
    }
    
    /**
     * Outputs the basket
     *
     * @param integer $id if of order  
     * @return OrderEntityInterface
     */
    public function __invoke($id)
    {
        return $this->getOrderService()->fetchSingleById($id);
    }
}
