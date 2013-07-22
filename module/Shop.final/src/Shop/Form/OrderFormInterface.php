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
namespace Shop\Form;

use Zend\Form\FormInterface;

/**
 * Shop Form interface
 * 
 * @package    Shop
 */
interface OrderFormInterface extends FormInterface
{
    /**
     * Add csrf element
     */
    public function addCsrfElement($name = 'tick');
        
    /**
     * Add id element
     */
    public function addIdElement($name = 'id');
        
    /**
     * Add status element
     */
    public function addStatusElement($options = array(), $name = 'status');
    
    /**
     * Add comments element
     */
    public function addCommentsElement($name = 'comments');
    
    /**
     * Add submit element
     */
    public function addSubmitElement($name = 'save', $label = 'Bestellen');
}
