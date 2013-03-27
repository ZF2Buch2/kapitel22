<?php
/**
 * ZF2 Buch Kapitel 22
 * 
 * Das Buch "Zend Framework 2 - Von den Grundlagen bis zur fertigen Anwendung"
 * von Ralf Eggert ist im Addison-Wesley Verlag erschienen. 
 * ISBN 978-3-8273-2994-3
 * 
 * @package    Cms
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Alle Listings sind urheberrechtlich geschützt!
 * @link       http://www.zendframeworkbuch.de/ und http://www.awl.de/2994
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
