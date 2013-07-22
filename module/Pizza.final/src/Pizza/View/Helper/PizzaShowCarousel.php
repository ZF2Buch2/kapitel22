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
namespace Pizza\View\Helper;

use Zend\Paginator\Paginator;
use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;

/**
 * Show pizza carousel view helper
 * 
 * Outputs the pizza list in a carousel
 * 
 * @package    Pizza
 */
class PizzaShowCarousel extends AbstractHelper
{
    /**
     * @var Paginator
     */
    protected $pizzaList;

    /**
     * Constructor
     *
     * @param  Paginator $pizzaList
     */
    public function __construct(Paginator $pizzaList)
    {
        $this->setPizzaList($pizzaList);
    }

    /**
     * Sets pizza pizzaList
     *
     * @param  Paginator $pizzaList
     * @return AbstractHelper
     */
    public function setPizzaList(Paginator $pizzaList = null)
    {
        $this->pizzaList = $pizzaList;
        return $this;
    }
    
    /**
     * Returns PizzaList
     *
     * @return Paginator
     */
    public function getPizzaList()
    {
        return $this->pizzaList;
    }
    
    /**
     * Outputs the pizza list in a carousel
     *
     * @return string 
     */
    public function __invoke()
    {
        $vm = new ViewModel(array(
            'pizzaList' => $this->getPizzaList(),
        ));
        $vm->setTemplate('widget/carousel');
        
        return $this->getView()->render($vm);
    }
}
