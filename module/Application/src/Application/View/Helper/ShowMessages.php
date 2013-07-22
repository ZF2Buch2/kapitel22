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
namespace Application\View\Helper;

use Zend\Mvc\Controller\Plugin\FlashMessenger;
use Zend\View\Helper\AbstractHelper;

/**
 * Show messages view helper
 * 
 * Outputs all messages from FlashMessenger and view
 * 
 * @package    Application
 */
class ShowMessages extends AbstractHelper
{
    /**
     * FlashMessenger
     *
     * @var FlashMessenger
     */
    protected $flashMessenger;

    /**
     * Constructor
     *
     * @param  FlashMessenger $flashMessenger
     */
    public function __construct(FlashMessenger $flashMessenger)
    {
        $this->setFlashMessenger($flashMessenger);
    }

    /**
     * Outputs message depending on flag
     *
     * @return string 
     */
    public function __invoke()
    {
        // get messages
        $messages = array_unique(array_merge(
            $this->flashMessenger->getMessages(), 
            $this->flashMessenger->getCurrentMessages()
        ));
        
        // initialize output
        $output = '';
        
        // loop through messages
        foreach ($messages as $message) {
            // create output
            $output.= '<div class="alert">';
            $output.= '<button class="close" data-dismiss="alert" type="button">×</button>';
            $output.= $message;
            $output.= '</div>';
        }

        // clear messages
        $this->flashMessenger->clearMessages();
        $this->flashMessenger->clearCurrentMessages();
        
        // return output
        return $output . "\n";
    }
    
    /**
     * Sets FlashMessenger
     *
     * @param  FlashMessenger $flashMessenger
     * @return AbstractHelper
     */
    public function setFlashMessenger(FlashMessenger $flashMessenger = null)
    {
        $this->flashMessenger = $flashMessenger;
        return $this;
    }
    
    /**
     * Returns FlashMessenger
     *
     * @return FlashMessenger
     */
    public function getFlashMessenger()
    {
        return $this->flashMessenger;
    }
}
