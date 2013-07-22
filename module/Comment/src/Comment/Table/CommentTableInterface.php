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
namespace Comment\Table;

use Comment\Entity\CommentEntityInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGatewayInterface;

/**
 * Comment table interface
 * 
 * Handles the comments table for the Comment module 
 * 
 * @package    Comment
 */
interface CommentTableInterface extends TableGatewayInterface
{
    /**
     * Constructor
     * 
     * @param Adapter $adapter database adapter
     */
    public function __construct(Adapter $adapter, CommentEntityInterface $entity);
    
    /**
     * Fetch comments by url
     * 
     * @param varchar $url url address of comment
     * @return CommentEntityInterface[]
     */
    public function fetchListByUrl($url);
    
    /**
     * Fetch count for comments by url
     * 
     * @param varchar $url url address of comment
     * @return CommentEntityInterface[]
     */
    public function fetchCountByUrl($url);
    
    /**
     * Fetch single comment by id
     * 
     * @param integer $id id of comment
     * @return CommentEntityInterface
     */
    public function fetchSingleById($id);
}
