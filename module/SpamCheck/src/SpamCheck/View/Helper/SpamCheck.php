<?php
/**
 * ZF2 Buch Kapitel 22
 * 
 * Das Buch "Zend Framework 2 - Von den Grundlagen bis zur fertigen Anwendung"
 * von Ralf Eggert ist im Addison-Wesley Verlag erschienen. 
 * ISBN 978-3-8273-2994-3
 * 
 * @package    SpamCheck
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Alle Listings sind urheberrechtlich geschützt!
 * @link       http://www.zendframeworkbuch.de/ und http://www.awl.de/2994
 */

/**
 * namespace definition and usage
 */
namespace SpamCheck\View\Helper;

use SpamCheck\Service\B8ServiceInterface;
use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;

/**
 * Provides access to b8 view helper
 * 
 * Outputs the the spam classification
 * 
 * @package    SpamCheck
 */
class SpamCheck extends AbstractHelper
{
    /**
     * @var B8ServiceInterface
     */
    protected $b8Service;

    /**
     * Constructor
     *
     * @param  B8ServiceInterface $b8Service
     */
    public function __construct(B8ServiceInterface $b8Service)
    {
        $this->setB8Service($b8Service);
    }

    /**
     * Sets comment b8Service
     *
     * @param  B8ServiceInterface $b8Service
     * @return AbstractHelper
     */
    public function setB8Service(B8ServiceInterface $b8Service = null)
    {
        $this->b8Service = $b8Service;
        return $this;
    }
    
    /**
     * Returns B8Service
     *
     * @return B8ServiceInterface
     */
    public function getB8Service()
    {
        return $this->b8Service;
    }
    
    /**
     * Returns itself
     *
     * @return SpamCheck 
     */
    public function __invoke()
    {
        // return view helper
        return $this;
    }
    
    /**
     * Classify message
     */
    public function classify($text, $round = 10)
    {
        $round = $round == 0 ? 10 : (integer) $round;
        return round($this->getB8Service()->classify($text), $round);
    }
}
