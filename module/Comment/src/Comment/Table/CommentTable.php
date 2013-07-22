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
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

/**
 * Comment table
 * 
 * Handles the comments table for the Comment module 
 * 
 * @package    Comment
 */
class CommentTable extends TableGateway implements CommentTableInterface
{
    /**
     * Constructor
     * 
     * @param Adapter $adapter database adapter
     */
    public function __construct(Adapter $adapter, CommentEntityInterface $entity)
    {
        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype($entity);
        
        parent::__construct('comments', $adapter, null, $resultSet);
    }
    
    /**
     * Fetch comments by url
     * 
     * @param varchar $url url address of comment
     * @return CommentEntityInterface[]
     */
    public function fetchListByUrl($url)
    {
        $select = $this->getSql()->select();
        $select->where->equalTo('url', $url);
        $select->where->equalTo('status', 'approved');
        $select->order('cdate ASC');
        
        return $this->selectWith($select);
    }
    
    /**
     * Fetch count for comments by url
     * 
     * @param varchar $url url address of comment
     * @return CommentEntityInterface[]
     */
    public function fetchCountByUrl($url)
    {
        $select = $this->getSql()->select();
        $select->where->equalTo('url', $url);
        $select->where->equalTo('status', 'approved');
        
        return $this->selectWith($select)->count();
    }
    
    /**
     * Fetch single comment by id
     * 
     * @param integer $id id of comment
     * @return CommentEntityInterface
     */
    public function fetchSingleById($id)
    {
        $select = $this->getSql()->select();
        $select->where->equalTo('id', $id);
        
        return $this->selectWith($select)->current();
    }
}
