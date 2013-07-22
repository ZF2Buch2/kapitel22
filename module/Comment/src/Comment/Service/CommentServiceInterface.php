<?php
/**
 * ZF2 Buch Kapitel 22
 * 
 * Das Buch "Zend Framework 2 - Das Praxisbuch"
 * von Ralf Eggert ist im Galileo-Computing Verlag erschienen. 
 * ISBN 978-3-8362-2610-3
 * 
 * @package    Comment
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Alle Listings sind urheberrechtlich geschützt!
 * @link       http://www.zendframeworkbuch.de/ und http://www.galileocomputing.de/3460
 */

/**
 * namespace definition and usage
 */
namespace Comment\Service;

use Comment\Entity\CommentEntityInterface;
use Comment\Form\CommentFormInterface;
use Comment\Table\CommentTableInterface;
use SpamCheck\Service\B8ServiceInterface;

/**
 * Comment Service interface
 * 
 * @package    Comment
 */
interface CommentServiceInterface
{
    /**
     * Constructor
     * 
     * @param CommentTableInterface $table
     */
    public function __construct(CommentTableInterface $table, array $config, B8ServiceInterface $b8Service);
    
    /**
     * Get user table
     * 
     * @return CommentTableInterface
     */
    public function getTable();
    
    /**
     * Set user table
     * 
     * @param CommentTableInterface $table
     * @return CommentServiceInterface
     */
    public function setTable(CommentTableInterface $table);
    
    /**
     * Get config
     * 
     * @param string $key config key
     * @return array
     */
    public function getConfig($key);
    
    /**
     * Set config
     * 
     * @param array $config
     * @return CommentServiceInterface
     */
    public function setConfig(array $config);
    
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
     * @return CommentFormInterface
     */
    public function getForm($type = 'create');

    /**
     * Set form
     * 
     * @param CommentFormInterface $form
     * @param string $type form type
     */
    public function setForm(CommentFormInterface $form, $type = 'create');

    /**
     * Fetch list by url
     *
     * @param varchar $url
     * @return CommentEntityInterface[]
     */
    public function fetchListByUrl($url);
    
    /**
     * Fetch count by url
     *
     * @param varchar $url
     * @return integer
     */
    public function fetchCountByUrl($url);
    
    /**
     * Fetch single by id
     *
     * @param varchar $id
     * @return CommentEntityInterface
     */
    public function fetchSingleById($id);
    
    /**
     * Fetch list of comments
     *
     * @param integer $page number of page
     * @return Paginator
     */
    public function fetchList($page = 1, $perPage = 4, $params = array());
    
    /**
     * Save a comment
     *
     * @param array $data input data
     * @param integer $id id of comment entry
     * @return CommentEntityInterface
     */
    public function save(array $data, $id = null);
    
    /**
     * Delete existing comment
     *
     * @param integer $id comment id
     * @param array $data input data
     * @return CommentEntityInterface
     */
    public function delete($id);
    
    /**
     * Update comment status
     *
     * @param integer $id comment id
     * @param string $status new status
     * @return CommentEntityInterface
     */
    public function updateStatus($id, $status);
}
