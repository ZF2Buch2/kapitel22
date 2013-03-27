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
namespace Pizza\Filter;

use Application\Filter\StringHtmlPurifier;
use Zend\InputFilter\FileInput;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;

/**
 * Pizza filter
 *
 * @package    Pizza
 */
class PizzaFilter extends InputFilter
{
    /**
     * Build filter
     */
    public function __construct()
    {
        $filterHtmlPurifier = new StringHtmlPurifier();

        $name = new Input('name');
        $name->setRequired(true);
        $name->getFilterChain()->attachByName('StringTrim');
        $name->getFilterChain()->attachByName('StripTags');
        $name->getValidatorChain()->attachByName('StringLength', array(
            'encoding' => 'UTF-8', 'min' => 5, 'max' => 128,
            'message'  => 'Name muss zwischen 5 und 128 Zeichen lang sein',
        ));

        $description = new Input('description');
        $description->setRequired(true);
        $description->getFilterChain()->attachByName('StringTrim');
        $description->getFilterChain()->attach($filterHtmlPurifier);

        $price = new Input('price');
        $price->setRequired(true);
        $price->getFilterChain()->attachByName('StringTrim');
        $price->getValidatorChain()->attachByName('Float', array(
            'message'  => 'Die Eingabe ist keine gültige Preisangabe',
        ));

        $crustId = new Input('crust_id');
        $crustId->setRequired(true);

        $file = new FileInput('picture');
        $file->setRequired(false);
        $file->getFilterChain()->attachByName(
            'filerenameupload',
            array(
                'target'    => LUIGI_ROOT . '/data/upload/tempfile.jpg',
                'overwrite' => true,
            )
        );
        $file->getValidatorChain()->attachByName(
            'fileimagesize',
            array(
                'minWidth'  => 200, 'maxWidth'  => 200, 
                'minHeight' => 150, 'maxHeight' => 150
            )
        );
        $file->getValidatorChain()->attachByName(
            'filemimetype',
            array('mimeType' => 'image/jpeg')
        );
        
        $this->add($name);
        $this->add($description);
        $this->add($price);
        $this->add($crustId);
        $this->add($file);
    }
}
