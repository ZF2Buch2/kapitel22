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
namespace User\Service;

use Zend\Authentication\AuthenticationService;
use User\Entity\UserEntityInterface;
use User\Form\UserFormInterface;
use User\Table\UserTableInterface;

/**
 * User Service interface
 * 
 * @package    User
 */
interface UserServiceInterface
{
    /**
     * Constructor
     * 
     * @param UserTableInterface $table
     */
    public function __construct(UserTableInterface $table, AuthenticationService $authentication);
    
    /**
     * Get user table
     * 
     * @return UserTableInterface
     */
    public function getTable();
    
    /**
     * Set user table
     * 
     * @param UserTableInterface $table
     * @return UserServiceInterface;
     */
    public function setTable(UserTableInterface $table);
    
    /**
     * Get service message
     * 
     * @return array
     */
    public function getMessage();
    
    /**
     * Clear service message
     */
    public function clearMessage();
    
    /**
     * Add service message
     * 
     * @param string new message
     */
    public function setMessage($message);
    
    /**
     * Get form with triggering the Event-Manager
     * 
     * @param  string $type form type
     * @return UserFormInterface
     */
    public function getForm($type = 'login');

    /**
     * Set register form
     * 
     * @param UserFormInterface $form
     * @param string $type form type
     */
    public function setForm(UserFormInterface $form, $type = 'login');

    /**
     * Fetch single by email
     *
     * @param varchar $email
     * @return UserEntityInterface
     */
    public function fetchSingleByEmail($email);
    
    /**
     * Fetch single by id
     *
     * @param varchar $id
     * @return UserEntityInterface
     */
    public function fetchSingleById($id);
    
    /**
     * Fetch list of users
     *
     * @param integer $page number of page
     * @return Paginator
     */
    public function fetchList($page = 1, $perPage = 15);
    
    /**
     * Save a user
     *
     * @param array $data input data
     * @param integer $id id of user entry
     * @return UserEntityInterface
     */
    public function save(array $data, $id = null);
    
    /**
     * Delete existing user
     *
     * @param integer $id user id
     * @param array $data input data
     * @return UserEntityInterface
     */
    public function delete($id);
    
    /**
     * Login user
     *
     * @param array $data input data
     * @return UserEntityInterface|false
     */
    public function login(array $data);
    
    /**
     * Logout user
     *
     * @return boolean
     */
    public function logout();
}
