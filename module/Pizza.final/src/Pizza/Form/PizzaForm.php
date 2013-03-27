<?php
/**
 * ZF2 Buch Kapitel 22
 * 
 * Das Buch "Zend Framework 2 - Von den Grundlagen bis zur fertigen Anwendung"
 * von Ralf Eggert ist im Addison-Wesley Verlag erschienen. 
 * ISBN 978-3-8273-2994-3
 * 
 * @package    Pizza
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Alle Listings sind urheberrechtlich geschützt!
 * @link       http://www.zendframeworkbuch.de/ und http://www.awl.de/2994
 */

/**
 * namespace definition and usage
 */
namespace Pizza\Form;

use Zend\Form\Element\Csrf;
use Zend\Form\Element\File;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\MultiCheckbox;
use Zend\Form\Element\Select;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Element\Submit;
use Zend\Form\Form;
use Zend\Form\FormInterface;

/**
 * Pizza Form
 * 
 * @package    Pizza
 */
class PizzaForm extends Form implements PizzaFormInterface
{
    /**
     * Add csrf element
     */
    public function addCsrfElement($name = 'tick')
    {
        $element = new Csrf($name);
        $this->add($element);
    }
        
    /**
     * Add id element
     */
    public function addIdElement($name = 'id')
    {
        $element = new Hidden($name);
        $this->add($element);
    }
        
    /**
     * Add status element
     */
    public function addStatusElement($options = array(), $name = 'status')
    {
        $element = new Select($name);
        $element->setLabel('Status');
        $element->setAttribute('class', 'span3');
        $element->setValueOptions($options);
        $this->add($element);
    }
    
    /**
     * Add name element
     */
    public function addNameElement($name = 'name')
    {
        $element = new Text($name);
        $element->setLabel('Name');
        $element->setAttribute('class', 'span3');
        $this->add($element);
    }
    
    /**
     * Add description element
     */
    public function addDescriptionElement($name = 'description')
    {
        $element = new Textarea($name);
        $element->setLabel('Beschreibung');
        $element->setAttribute('class', 'ckeditor');
        $this->add($element);
    }
    
    /**
     * Add price element
     */
    public function addPriceElement($name = 'price')
    {
        $element = new Text($name);
        $element->setLabel('Preis');
        $element->setAttribute('class', 'span3');
        $element->setAttribute('maxlength', '5');
        $this->add($element);
    }
    
    /**
     * Add crust element
     */
    public function addCrustElement($options = array(), $name = 'crust_id')
    {
        $element = new Select($name);
        $element->setLabel('Pizzaboden');
        $element->setAttribute('class', 'span3');
        $element->setValueOptions($options);
        $this->add($element);
    }
    
    /**
     * Add toppings element
     */
    public function addToppingsElement($options = array(), $name = 'toppings')
    {
        $element = new MultiCheckbox($name);
        $element->setLabel('Pizzabeläge');
        $element->setValueOptions($options);
        $this->add($element);
    }
    
    /**
     * Add picture element
     */
    public function addPictureElement($name = 'picture')
    {
        $element = new File($name);
        $element->setLabel('Bild-Upload');
        $this->add($element);
        
        $this->setAttribute('enctype','multipart/form-data');
    }
    
    /**
     * Add submit element
     */
    public function addSubmitElement($name = 'save', $label = 'Speichern')
    {
        $element = new Submit($name);
        $element->setValue($label);
        $element->setAttribute('class', 'btn');
        $this->add($element);
    }
    
    /**
     * Bind an object to the form
     */
    public function bind($object, $flags = FormInterface::VALUES_NORMALIZED)
    {
        parent::bind($object, $flags);
        
        if ($this->get('toppings')) {
            $this->get('toppings')->setValue(
                array_keys($object->getToppings())
            );
        }
    }
}
