<?php
/**
 * ZF2 Buch Kapitel 22
 * 
 * Das Buch "Zend Framework 2 - Das Praxisbuch"
 * von Ralf Eggert ist im Galileo-Computing Verlag erschienen. 
 * ISBN 978-3-8362-2610-3
 * 
 * @package    SpamCheck
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Alle Listings sind urheberrechtlich geschützt!
 * @link       http://www.zendframeworkbuch.de/ und http://www.galileocomputing.de/3460
 */

/**
 * namespace definition and usage
 */
namespace SpamCheck\Controller\Plugin;

use SpamCheck\Service\B8ServiceInterface;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

/**
 * Provides access to b8
 * 
 * Provides access to the B8Service
 * 
 * @package    SpamCheck
 */
class SpamCheck extends AbstractPlugin
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
        // return plugin
        return $this;
    }
    
    /**
     * Mark message as spam
     */
    public function markAsSpam($text)
    {
        return $this->getB8Service()->markAsSpam($text);
    }
    
    /**
     * Mark message as ham
     */
    public function markAsHam($text)
    {
        return $this->getB8Service()->markAsHam($text);
    }
    
    /**
     * Mark message as no spam
     */
    public function markAsNoSpam($text)
    {
        return $this->getB8Service()->markAsNoSpam($text);
    }
    
    /**
     * Mark message as no ham
     */
    public function markAsNoHam($text)
    {
        return $this->getB8Service()->markAsNoHam($text);
    }
}
