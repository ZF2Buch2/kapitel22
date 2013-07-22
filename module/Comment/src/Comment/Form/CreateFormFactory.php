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

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Create form factory
 * 
 * @package    Comment
 */
class CreateFormFactory implements FactoryInterface
{
    /**
     * Create Service Factory
     * 
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $inputFilterManager = $serviceLocator->get('InputFilterManager');
        
        $form = new CommentForm('create');
        $form->addCsrfElement();
        $form->addUrlElement();
        $form->addEmailElement();
        $form->addNameElement();
        $form->addMessageElement();
        $form->addSubmitElement('save', 'Speichern');
        $form->addSubmitElement('cancel', 'Abbrechen');
        $form->setInputFilter($inputFilterManager->get('Comment\Filter\Comment'));
        $form->setValidationGroup(array(
            'url', 'email', 'name', 'message', 'save', 'cancel'
        ));
        return $form;
    }
}
