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
namespace Pizza\Form;

use Pizza\Filter\PizzaFilter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Create form factory
 * 
 * @package    Pizza
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
        $pizzaEntity   = $serviceLocator->get('Pizza\Entity\Pizza');
        $statusOptions = $pizzaEntity->getStatusNames();
        
        $crustTable   = $serviceLocator->get('Pizza\Table\Crust');
        $crustOptions = $crustTable->fetchOptions();
        
        $toppingTable   = $serviceLocator->get('Pizza\Table\Topping');
        $toppingOptions = $toppingTable->fetchOptions();
        
        $form = new PizzaForm('create');
        $form->addCsrfElement();
        $form->addStatusElement($statusOptions, 'status');
        $form->addNameElement();
        $form->addPriceElement();
        $form->addCrustElement($crustOptions, 'crust_id');
        $form->addToppingsElement($toppingOptions, 'toppings');
        $form->addDescriptionElement();
        $form->addSubmitElement('save', 'Speichern');
        $form->addSubmitElement('cancel', 'Abbrechen');
        $form->setInputFilter(new PizzaFilter());
        $form->setValidationGroup(array(
            'status', 'name', 'description', 'price', 'crust_id', 'toppings',
            'save', 'cancel'
        ));
        return $form;
    }
}
