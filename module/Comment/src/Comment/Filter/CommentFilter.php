<?php
/**
 * ZF2 Buch Kapitel 22
 * 
 * Das Buch "Zend Framework 2 - Das Praxisbuch"
 * von Ralf Eggert ist im Galileo-Computing Verlag erschienen. 
 * ISBN 978-3-8362-2610-3
 * 
 * @package    Comment
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Alle Listings sind urheberrechtlich geschützt!
 * @link       http://www.zendframeworkbuch.de/ und http://www.galileocomputing.de/3460
 */

/**
 * namespace definition and usage
 */
namespace Comment\Filter;

use Zend\InputFilter\InputFilter;

/**
 * Comment filter
 * 
 * @package    Comment
 */
class CommentFilter extends InputFilter
{
    /**
     * Build filter
     */
    public function init()
    {
        $this->add(array(
            'name'       => 'email',
            'required'   => true,
            'filters'    => array(
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'    => 'EmailAddress',
                    'options' => array(
                        'useDomainCheck' => false, 
                        'message'        => 'Keine gültige E-Mail-Adresse',
                    ),
                ),
            ),
        ));
        
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
                        'message'  => 'Name nur 5 - 128 Zeichen erlaubt',
                    ),
                ),
            ),
        ));
        
        $this->add(array(
            'name'       => 'message',
            'required'   => true,
            'filters'    => array(
                array('name' => 'StringTrim'),
                array('name' => 'stringHtmlPurifier'),
            ),
        ));
    }
}
