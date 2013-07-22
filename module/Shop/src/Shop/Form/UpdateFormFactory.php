<?php
/**
 * ZF2 Buch Kapitel 22
 * 
 * Das Buch "Zend Framework 2 - Das Praxisbuch"
 * von Ralf Eggert ist im Galileo-Computing Verlag erschienen. 
 * ISBN 978-3-8362-2610-3
 * 
 * @package    Shop
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Alle Listings sind urheberrechtlich geschützt!
 * @link       http://www.zendframeworkbuch.de/ und http://www.galileocomputing.de/3460
 */

/**
 * namespace definition and usage
 */
namespace Shop\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Update form factory
 * 
 * @package    Shop
 */
class UpdateFormFactory implements FactoryInterface
{
    /**
     * Create Service Factory
     * 
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $inputFilterManager = $serviceLocator->get('InputFilterManager');
        
        $shopEntity   = $serviceLocator->get('Shop\Entity\Order');
        $statusOptions = $shopEntity->getStatusNames();
        
        $form = new OrderForm('update');
        $form->addIdElement();
        $form->addCsrfElement();
        $form->addStatusElement($statusOptions, 'status');
        $form->addSubmitElement('save', 'Speichern');
        $form->addSubmitElement('cancel', 'Abbrechen');
        $form->setInputFilter($inputFilterManager->get('Shop\Filter\Order'));
        $form->setValidationGroup(array(
            'id', 'status', 'save', 'cancel'
        ));
        return $form;
    }
}
