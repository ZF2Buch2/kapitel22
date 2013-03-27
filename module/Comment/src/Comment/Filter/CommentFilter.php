<?php
/**
 * ZF2 Buch Kapitel 22
 * 
 * Das Buch "Zend Framework 2 - Von den Grundlagen bis zur fertigen Anwendung"
 * von Ralf Eggert ist im Addison-Wesley Verlag erschienen. 
 * ISBN 978-3-8273-2994-3
 * 
 * @package    Comment
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Alle Listings sind urheberrechtlich geschützt!
 * @link       http://www.zendframeworkbuch.de/ und http://www.awl.de/2994
 */

/**
 * namespace definition and usage
 */
namespace Comment\Filter;

use Application\Filter\StringHtmlPurifier;
use Zend\InputFilter\Input;
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
    public function __construct()
    {
        $filterHtmlPurifier = new StringHtmlPurifier();

        $email = new Input('email');
        $email->setRequired(true);
        $email->getFilterChain()->attachByName('StringTrim');
        $email->getValidatorChain()->attachByName('EmailAddress', array(
                'useDomainCheck' => false,
                'message'        => 'Keine gültige E-Mail-Adresse',
        ));

        $name = new Input('name');
        $name->setRequired(true);
        $name->getFilterChain()->attachByName('StringTrim');
        $name->getFilterChain()->attachByName('StripTags');
        $name->getValidatorChain()->attachByName('StringLength', array(
                'encoding' => 'UTF-8', 'min' => 5, 'max' => 128,
                'message'  => 'Name muss zwischen 5 und 128 Zeichen lang sein',
        ));

        $message = new Input('message');
        $message->setRequired(true);
        $message->getFilterChain()->attachByName('StringTrim');
        $message->getFilterChain()->attach($filterHtmlPurifier);

        $this->add($email);
        $this->add($name);
        $this->add($message);
    }
}
