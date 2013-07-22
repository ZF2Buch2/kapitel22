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
namespace Comment\Form;

use Zend\Form\FormInterface;

/**
 * Comment Form interface
 * 
 * @package    Comment
 */
interface CommentFormInterface extends FormInterface
{
    /**
     * Add csrf element
     */
    public function addCsrfElement($name = 'tick');
        
    /**
     * Add id element
     */
    public function addIdElement($name = 'id');
        
    /**
     * Add url element
     */
    public function addUrlElement($name = 'url');
        
    /**
     * Add status element
     */
    public function addStatusElement($options = array(), $name = 'status');
    
    /**
     * Add email element
     */
    public function addEmailElement($email = 'email');
    
    /**
     * Add name element
     */
    public function addNameElement($name = 'name');
    
    /**
     * Add message element
     */
    public function addMessageElement($name = 'message');
    
    /**
     * Add submit element
     */
    public function addSubmitElement($name = 'save', $label = 'Speichern');
}
