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
namespace SpamCheck\Service;

/**
 * SpamCheck B8 Service
 * 
 * @package    SpamCheck
 */
class B8Service implements B8ServiceInterface
{
    /**
     * @var \b8
     */
    protected $b8 = null;
    
    /**
     * Constructor
     * 
     * @param \b8
     */
    public function __construct(\b8 $b8)
    {
        $this->setB8($b8);
    }
    
    /**
     * Get b8 service
     *
     * @return \b8
     */
    public function getB8()
    {
        return $this->b8;
    }
    
    /**
     * Set b8 service
     *
     * @param \b8 $b8
     * @return B8ServiceInterface
     */
    public function setB8(\b8 $b8)
    {
        $this->b8 = $b8;
        return $this;
    }
    
    /**
     * Detect text as spam
     *
     * @param string $text to detect
     * @return boolean
     */
    public function detectSpam($text)
    {
        $result = $this->classify($text);
        
        if ($result > $this->getB8()->config['rob_x']) {
            $this->markAsSpam($text);
            return true;
        } else {
            $this->markAsHam($text);
            return false;
        }
    }
    
    /**
     * Mark text as spam
     *
     * @param string $text to classify
     * @return boolean
     */
    public function markAsSpam($text)
    {
        // mark as spam
        $this->getB8()->learn($text, \b8::SPAM);
        return true;
    }
    
    /**
     * Mark text as ham
     *
     * @param string $text to classify
     * @return boolean
     */
    public function markAsHam($text)
    {
        // mark as ham
        $this->getB8()->learn($text, \b8::HAM);
        return true;
    }
    
    /**
     * Mark text as no spam
     *
     * @param string $text to classify
     * @return boolean
     */
    public function markAsNoSpam($text)
    {
        // mark as spam
        $this->getB8()->unlearn($text, \b8::SPAM);
        return true;
    }
    
    /**
     * Mark text as no ham
     *
     * @param string $text to classify
     * @return boolean
     */
    public function markAsNoHam($text)
    {
        // mark as ham
        $this->getB8()->unlearn($text, \b8::HAM);
        return true;
    }
    
    /**
     * Classify text
     *
     * @param string $text to classify
     * @return float
     */
    public function classify($text)
    {
        // classify text
        return $this->getB8()->classify($text);
    }
}
