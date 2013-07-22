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
 * Show picture view helper
 * 
 * Outputs the picture for a pizza
 * 
 * @package    Pizza
 */
class PizzaShowPicture extends AbstractHelper
{
    /**
     * Outputs the picture for a pizza
     *
     * @return string 
     */
    public function __invoke(PizzaEntityInterface $pizza, $class = '')
    {
        $pictureFile = '/img/uploads/pizza' . $pizza->getId() . '.jpg';
        $picturePath = LUIGI_ROOT . '/public' . $pictureFile;
        
        if (!file_exists($picturePath))
        {
            $pictureFile = '/img/pizza/keinbild.jpg';
        }
        
        $output = '<img src="' . $pictureFile . '" class="thumbnail ' . $class .'" />';
        
        return $output;
    }
}
