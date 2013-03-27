<?php
/**
 * ZF2 Buch Kapitel 22
 * 
 * Das Buch "Zend Framework 2 - Von den Grundlagen bis zur fertigen Anwendung"
 * von Ralf Eggert ist im Addison-Wesley Verlag erschienen. 
 * ISBN 978-3-8273-2994-3
 * 
 * @package    User
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Alle Listings sind urheberrechtlich geschützt!
 * @link       http://www.zendframeworkbuch.de/ und http://www.awl.de/2994
 */

/**
 * namespace definition and usage
 */
namespace User\Filter;

use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;

/**
 * User filter
 * 
 * @package    User
 */
class UserFilter extends InputFilter
{
    /**
     * Build filter
     */
    public function __construct()
    {
        $role = new Input('role');
        $role->setRequired(true);
        $role->getValidatorChain()->attachByName('InArray', array(
            'haystack' => array('guest', 'customer', 'staff', 'admin')
        ));
        
        $email = new Input('email');
        $email->setRequired(true);
        $email->getFilterChain()->attachByName('StringTrim');
        $email->getValidatorChain()->attachByName('EmailAddress', array(
            'useDomainCheck' => false, 
            'message'        => 'Keine gültige E-Mail-Adresse',
        ));
        
        $pass = new Input('pass');
        $pass->setRequired(true);
        $pass->getFilterChain()->attachByName('StringTrim');
        $pass->getValidatorChain()->attachByName('StringLength', array(
            'encoding' => 'UTF-8', 'min' => 5, 'max' => 128,
            'message'  => 'Passwort muss mindestens 5 Zeichen lang sein',
        ));
        
        $firstname = new Input('firstname');
        $firstname->setRequired(true);
        $firstname->getFilterChain()->attachByName('StringTrim');
        $firstname->getFilterChain()->attachByName('StripTags');
        $firstname->getValidatorChain()->attachByName('StringLength', array(
            'encoding' => 'UTF-8', 'min' => 1, 'max' => 64
        ));
        
        $lastname = new Input('lastname');
        $lastname->setRequired(true);
        $lastname->getFilterChain()->attachByName('StringTrim');
        $lastname->getFilterChain()->attachByName('StripTags');
        $lastname->getValidatorChain()->attachByName('StringLength', array(
            'encoding' => 'UTF-8', 'min' => 1, 'max' => 64)
        );
        
        $this->add($role);
        $this->add($email);
        $this->add($pass);
        $this->add($firstname);
        $this->add($lastname);
    }
}
