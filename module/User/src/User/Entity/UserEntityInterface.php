<?php
/**
 * ZF2 Buch Kapitel 22
 * 
 * Das Buch "Zend Framework 2 - Von den Grundlagen bis zur fertigen Anwendung"
 * von Ralf Eggert ist im Addison-Wesley Verlag erschienen. 
 * ISBN 978-3-8273-2994-3
 * 
 * @package    User
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Alle Listings sind urheberrechtlich geschützt!
 * @link       http://www.zendframeworkbuch.de/ und http://www.awl.de/2994
 */

/**
 * namespace definition and usage
 */
namespace User\Entity;

use Zend\Stdlib\ArraySerializableInterface;

/**
 * User entity interface
 * 
 * @package    User
 */
interface UserEntityInterface extends ArraySerializableInterface
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
     * Set role
     * 
     * @param string $role
     */
    public function setRole($role);
    
    /**
     * Get role
     * 
     * @return string $role
     */
    public function getRole();
    
    /**
     * Get role name
     * 
     * @return string $role
     */
    public function getRoleName();
    
    /**
     * Get role names
     * 
     * @return array list of roles
     */
    public function getRoleNames();
    
    /**
     * Set email
     * 
     * @param string $email
     */
    public function setEmail($email);
    
    /**
     * Get email
     * 
     * @return string $email
     */
    public function getEmail();
    
    /**
     * Set pass
     * 
     * @param string $pass
     */
    public function setPass($pass);
    
    /**
     * Get pass
     * 
     * @return string $pass
     */
    public function getPass();
    
    /**
     * Set firstname
     * 
     * @param string $firstname
     */
    public function setFirstname($firstname);
    
    /**
     * Get firstname
     * 
     * @return string $firstname
     */
    public function getFirstname();
    
    /**
     * Set lastname
     * 
     * @param string $lastname
     */
    public function setLastname($lastname);
    
    /**
     * Get lastname
     * 
     * @return string $lastname
     */
    public function getLastname();
}
