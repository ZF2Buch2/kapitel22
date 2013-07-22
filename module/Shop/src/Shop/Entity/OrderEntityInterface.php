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
namespace Shop\Entity;

use User\Entity\UserEntityInterface;
use Zend\Stdlib\ArraySerializableInterface;

/**
 * Shop entity interface
 * 
 * @package    Shop
 */
interface OrderEntityInterface extends ArraySerializableInterface
{
    /**
     * Set id
     * 
     * @param integer $id
     */
    public function setId($id);
    
    /**
     * Get id
     * 
     * @return integer $id
     */
    public function getId();
    
    /**
     * Set cdate
     * 
     * @param string $cdate
     */
    public function setCdate($cdate);
    
    /**
     * Get cdate
     * 
     * @return string $cdate
     */
    public function getCdate();
    
    /**
     * Set status
     * 
     * @param string $status
     */
    public function setStatus($status);
    
    /**
     * Get status
     * 
     * @return string $status
     */
    public function getStatus();
    
    /**
     * Get status name
     * 
     * @return string $status
     */
    public function getStatusName();
    
    /**
     * Get status names
     * 
     * @return array list of stati
     */
    public function getStatusNames();
    
    /**
     * Set positions
     * 
     * @param string $positions
     */
    public function setPositions($positions);
    
    /**
     * Get positions
     * 
     * @return string $positions
     */
    public function getPositions();
    
    /**
     * Set comments
     * 
     * @param string $comments
     */
    public function setComments($comments);
    
    /**
     * Get comments
     * 
     * @return string $comments
     */
    public function getComments();
    
    /**
     * Set userId
     * 
     * @param string $userId
     */
    public function setUserId($userId);
    
    /**
     * Get userId
     * 
     * @return string $userId
     */
    public function getUserId();
    
    /**
     * Set identity
     * 
     * @param UserEntityInterface $identity
     */
    public function setIdentity(UserEntityInterface $identity);
    
    /**
     * Get identity
     * 
     * @return UserEntityInterface $identity
     */
    public function getIdentity();
}
