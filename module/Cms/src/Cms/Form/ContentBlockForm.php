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

use Zend\Form\Element\Hidden;
use Zend\Form\Element\Button;
use Zend\Form\Form;

/**
 * Cms Form
 * 
 * @package    Cms
 */
class ContentBlockForm extends Form implements ContentBlockFormInterface
{
    /**
     * Add hidden element
     */
    public function addHiddenElement($name = 'url', $value = '')
    {
        $element = new Hidden($name);
        $element->setValue($value);
        $this->add($element);
    }
        
    /**
     * Add button element
     */
    public function addButtonElement(
        $name = 'cms_save', $label = 'Speichern', $onClick = '',
        $disabled = 'disabled'
    )
    {
        $element = new Button($name);
        $element->setLabel($label);
        $element->setAttribute('class', 'btn');
        $element->setAttribute('id', $name);
        $element->setAttribute('onClick', $onClick);
        $element->setAttribute('disabled', $disabled);
        $this->add($element);
    }
}
