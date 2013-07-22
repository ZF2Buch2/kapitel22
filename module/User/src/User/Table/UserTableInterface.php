<?php
/**
 * ZF2 Buch Kapitel 22
 * 
 * Das Buch "Zend Framework 2 - Das Praxisbuch"
 * von Ralf Eggert ist im Galileo-Computing Verlag erschienen. 
 * ISBN 978-3-8362-2610-3
 * 
 * @package    User
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Alle Listings sind urheberrechtlich geschützt!
 * @link       http://www.zendframeworkbuch.de/ und http://www.galileocomputing.de/3460
 */

/**
 * namespace definition and usage
 */
namespace User\Table;

use User\Entity\UserEntityInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGatewayInterface;

/**
 * User table interface
 * 
 * Handles the users table for the User module 
 * 
 * @package    User
 */
interface UserTableInterface extends TableGatewayInterface
{
    /**
     * Constructor
     * 
     * @param Adapter $adapter database adapter
     */
    public function __construct(Adapter $adapter, UserEntityInterface $entity);
    
    /**
     * Fetch single user by email
     * 
     * @param varchar $email email address of user
     * @return UserEntityInterface
     */
    public function fetchSingleByEmail($email);
    
    /**
     * Fetch single user by id
     * 
     * @param integer $id id ofuser
     * @return UserEntityInterface
     */
    public function fetchSingleById($id);
}
