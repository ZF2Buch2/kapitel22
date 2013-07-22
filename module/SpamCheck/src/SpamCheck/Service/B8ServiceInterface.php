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
namespace SpamCheck\Service;

/**
 * SpamCheck B8 Service interface
 * 
 * @package    SpamCheck
 */
interface B8ServiceInterface
{
    /**
     * Constructor
     * 
     * @param \b8
     */
    public function __construct(\b8 $b8);
    
    /**
     * Get b8 service
     *
     * @return \b8
     */
    public function getB8();
    
    /**
     * Set b8 service
     *
     * @param \b8 $b8
     * @return B8ServiceInterface
     */
    public function setB8(\b8 $b8);
    
    /**
     * Detect text as spam
     *
     * @param string $text to detect
     * @return boolean
     */
    public function detectSpam($text);
    
    /**
     * Mark comment as spam
     *
     * @param string $text to classify
     * @return boolean
     */
    public function markAsSpam($text);
    
    /**
     * Mark comment as ham
     *
     * @param string $text to classify
     * @return boolean
     */
    public function markAsHam($text);
    
    /**
     * Mark comment as no spam
     *
     * @param string $text to classify
     * @return boolean
     */
    public function markAsNoSpam($text);
    
    /**
     * Mark comment as no ham
     *
     * @param string $text to classify
     * @return boolean
     */
    public function markAsNoHam($text);
    
    /**
     * Classify text
     *
     * @param string $text to classify
     * @return float
     */
    public function classify($text);
}
