<?php
/**
 * ZF2 Buch Kapitel 22
 * 
 * Das Buch "Zend Framework 2 - Von den Grundlagen bis zur fertigen Anwendung"
 * von Ralf Eggert ist im Addison-Wesley Verlag erschienen. 
 * ISBN 978-3-8273-2994-3
 * 
 * @package    Blog
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Alle Listings sind urheberrechtlich geschützt!
 * @link       http://www.zendframeworkbuch.de/ und http://www.awl.de/2994
 */

/**
 * namespace definition and usage
 */
namespace Blog\Table;

use Blog\Entity\BlogEntityInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGatewayInterface;

/**
 * Blog table interface
 * 
 * Handles the blogs table for the Blog module 
 * 
 * @package    Blog
 */
interface BlogTableInterface extends TableGatewayInterface
{
    /**
     * Constructor
     * 
     * @param Adapter $adapter database adapter
     */
    public function __construct(Adapter $adapter, BlogEntityInterface $entity);
    
    /**
     * Fetch single blog by url
     * 
     * @param varchar $url url address of blog
     * @return BlogEntityInterface
     */
    public function fetchSingleByUrl($url);
    
    /**
     * Fetch single blog by id
     * 
     * @param integer $id id ofblog
     * @return BlogEntityInterface
     */
    public function fetchSingleById($id);
}
