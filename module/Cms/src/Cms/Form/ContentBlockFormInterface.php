<?php
/**
 * ZF2 Buch Kapitel 22
 * 
 * Das Buch "Zend Framework 2 - Das Praxisbuch"
 * von Ralf Eggert ist im Galileo-Computing Verlag erschienen. 
 * ISBN 978-3-8362-2610-3
 * 
 * @package    Cms
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Alle Listings sind urheberrechtlich geschützt!
 * @link       http://www.zendframeworkbuch.de/ und http://www.galileocomputing.de/3460
 */

/**
 * namespace definition and usage
 */
namespace Cms\Form;

use Zend\Form\FormInterface;

/**
 * Cms Form
 * 
 * @package    Cms
 */
interface ContentBlockFormInterface extends FormInterface
{
    /**
     * Add hidden element
     */
    public function addHiddenElement($name = 'url', $value = '');
        
    /**
     * Add button element
     */
    public function addButtonElement(
        $name = 'cms_save', $label = 'Speichern', $onClick = '',
        $disabled = 'disabled'
    );
}
