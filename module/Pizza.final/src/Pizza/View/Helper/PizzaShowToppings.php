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

use Pizza\Entity\PizzaEntityInterface;
use Zend\View\Helper\AbstractHelper;

/**
 * Show toppings view helper
 * 
 * Outputs the toppings for a pizza
 * 
 * @package    Pizza
 */
class PizzaShowToppings extends AbstractHelper
{
    /**
     * Outputs the toppings for a pizza
     *
     * @return string 
     */
    public function __invoke(PizzaEntityInterface $pizza)
    {
        if (count($pizza->getToppings()) == 0) {
            return '-';
        }
        
        $output = '';
        
        $count = count($pizza->getToppings());
        
        foreach ($pizza->getToppings() as $key => $topping) {
            $output .= $topping->getName();
            $output .= ($count > 1) ? ', ' : '';
            $count--;
        }
        
        return $output;
    }
}
