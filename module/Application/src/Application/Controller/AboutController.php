<?php
/**
 * ZF2 Buch Kapitel 22
 * 
 * Das Buch "Zend Framework 2 - Das Praxisbuch"
 * von Ralf Eggert ist im Galileo-Computing Verlag erschienen. 
 * ISBN 978-3-8362-2610-3
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Alle Listings sind urheberrechtlich geschützt!
 * @link       http://www.zendframeworkbuch.de/ und http://www.galileocomputing.de/3460
 */

/**
 * namespace definition and usage
 */
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * About controller
 * 
 * Handles the homepage and other pages
 * 
 * @package    Application
 */
class AboutController extends AbstractActionController
{
    /**
     * Handle about page
     */
    public function indexAction()
    {
        return new ViewModel();
    }
    
    /**
     * Handle imprint page
     */
    public function imprintAction()
    {
        return new ViewModel();
    }
    
    /**
     * Handle team page
     */
    public function teamAction()
    {
        return new ViewModel();
    }
    
    /**
     * Handle contact page
     */
    public function contactAction()
    {
        return new ViewModel();
    }
}
