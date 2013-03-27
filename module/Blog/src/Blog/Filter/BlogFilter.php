<?php
/**
 * ZF2 Buch Kapitel 22
 * 
 * Das Buch "Zend Framework 2 - Von den Grundlagen bis zur fertigen Anwendung"
 * von Ralf Eggert ist im Addison-Wesley Verlag erschienen. 
 * ISBN 978-3-8273-2994-3
 * 
 * @package    Blog
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Alle Listings sind urheberrechtlich geschützt!
 * @link       http://www.zendframeworkbuch.de/ und http://www.awl.de/2994
 */

/**
 * namespace definition and usage
 */
namespace Blog\Filter;

namespace Blog\Filter;

use Application\Filter\StringHtmlPurifier;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;

/**
 * Blog filter
 * 
 * @package    Blog
 */
class BlogFilter extends InputFilter
{
    /**
     * Build filter
     */
    public function __construct()
    {
        $filterHtmlPurifier = new StringHtmlPurifier();
        
        $title = new Input('title');
        $title->setRequired(true);
        $title->getFilterChain()->attachByName('StringTrim');
        $title->getFilterChain()->attachByName('StripTags');
        $title->getValidatorChain()->attachByName('StringLength', array(
            'encoding' => 'UTF-8', 'min' => 5, 'max' => 128,
            'message'  => 'Überschrift nur 5 - 128 Zeichen erlaubt',
        ));
        
        $teaser = new Input('teaser');
        $teaser->setRequired(true);
        $teaser->getFilterChain()->attach($filterHtmlPurifier);
        $teaser->getFilterChain()->attachByName('StringTrim');
        
        $content = new Input('content');
        $content->setRequired(true);
        $content->getFilterChain()->attach($filterHtmlPurifier);
        $content->getFilterChain()->attachByName('StringTrim');
        
        $this->add($title);
        $this->add($teaser);
        $this->add($content);
    }
}
