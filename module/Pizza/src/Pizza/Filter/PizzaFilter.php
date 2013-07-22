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
namespace Pizza\Filter;

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
    public function init()
    {
        $this->add(array(
            'name'       => 'name',
            'required'   => true,
            'filters'    => array(
                array('name' => 'StringTrim'),
                array('name' => 'StripTags'),
            ),
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8', 'min' => 5, 'max' => 128,
                        'message'  => 'Überschrift nur 5 - 128 Zeichen erlaubt',
                    ),
                ),
            ),
        ));
        
        $this->add(array(
            'name'       => 'description',
            'required'   => true,
            'filters'    => array(
                array('name' => 'StringTrim'),
                array('name' => 'StringHtmlPurifier'),
            ),
        ));
        
        $this->add(array(
            'name'       => 'price',
            'required'   => true,
            'filters'    => array(
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'    => 'Float',
                    'options' => array(
                        'message'  => 'Die Eingabe ist keine gültige Preisangabe',
                    ),
                ),
            ),
        ));
        
        $this->add(array(
            'name'       => 'crust_id',
            'required'   => true,
        ));
        
        $this->add(array(
            'type'       => 'Zend\InputFilter\FileInput',
            'name'       => 'picture',
            'required'   => false,
            'filters'    => array(
                array(
                    'name'    => 'FileRenameUpload',
                    'options' => array(
                        'target'    => LUIGI_ROOT . '/data/upload/tempfile.jpg',
                        'overwrite' => true,
                    ),
                ),
            ),
            'validators' => array(
                array(
                    'name'    => 'FileImageSize',
                    'options' => array(
                        'minWidth'  => 200, 'maxWidth'  => 200, 
                        'minHeight' => 150, 'maxHeight' => 150,
                    ),
                ),
                array(
                    'name'    => 'FileMimeType',
                    'options' => array(
                        'mimeType' => 'image/jpeg',
                    ),
                ),
            ),
        ));
    }
}
