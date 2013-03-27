<?php
/**
 * ZF2 Buch Kapitel 22
 * 
 * Das Buch "Zend Framework 2 - Von den Grundlagen bis zur fertigen Anwendung"
 * von Ralf Eggert ist im Addison-Wesley Verlag erschienen. 
 * ISBN 978-3-8273-2994-3
 * 
 * @package    Shop
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Alle Listings sind urheberrechtlich geschützt!
 * @link       http://www.zendframeworkbuch.de/ und http://www.awl.de/2994
 */

/**
 * namespace definition and usage
 */
namespace Shop\Filter;

use Application\Filter\StringHtmlPurifier;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;

/**
 * Order filter
 * 
 * @package    Shop
 */
class OrderFilter extends InputFilter
{
    /**
     * Build filter
     */
    public function __construct()
    {
        $filterHtmlPurifier = new StringHtmlPurifier();
        
        $comments = new Input('comments');
        $comments->setRequired(false);
        $comments->getFilterChain()->attachByName('StringTrim');
        $comments->getFilterChain()->attach($filterHtmlPurifier);
        
        $this->add($comments);
    }
}
