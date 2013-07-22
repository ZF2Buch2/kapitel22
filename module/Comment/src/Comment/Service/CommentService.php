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

use Zend\Db\Adapter\Exception\InvalidQueryException;
use Zend\Db\TableGateway\TableGateway;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Session\Container;
use Comment\Entity\CommentEntityInterface;
use Comment\Entity\CommentEntity;
use Comment\Form\CommentFormInterface;
use Comment\Table\CommentTableInterface;
use SpamCheck\Service\B8ServiceInterface;

/**
 * Comment Service
 * 
 * @package    Comment
 */
class CommentService implements EventManagerAwareInterface, CommentServiceInterface
{
    /**
     * Default session namespace
     */
    const NAMESPACE_DEFAULT = 'Comment_Session';
    
    /**
     * @var EventManagerInterface
     */
    protected $eventManager = null;
    
    /**
     * @var CommentFormInterface[]
     */
    protected $forms = array();

    /**
     * @var CommentTableInterface
     */
    protected $table = null;
    
    /**
     * @var string
     */
    protected $message = null;
    
    /**
     * @var array
     */
    protected $config = array();
    
    /**
     * @var B8ServiceInterface
     */
    protected $b8Service;

    /**
     * Constructor
     * 
     * @param CommentTableInterface $table
     */
    public function __construct(
        CommentTableInterface $table, array $config, B8ServiceInterface $b8Service
    ) {
        $this->setTable($table);
        $this->setConfig($config);
        $this->setB8Service($b8Service);
    }
    
    /**
     * Inject an EventManager instance
     *
     * @param  EventManagerInterface $eventManager
     * @return void
     */
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $eventManager->setIdentifiers(array(__CLASS__));
        $this->eventManager = $eventManager;
    }
    
    /**
     * Retrieve the event manager
     *
     * Lazy-loads an EventManager instance if none registered.
     *
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
        return $this->eventManager;
    }
    
    /**
     * Get user table
     * 
     * @return CommentTableInterface
     */
    public function getTable()
    {
        return $this->table;
    }
    
    /**
     * Set user table
     * 
     * @param CommentTableInterface $table
     * @return CommentServiceInterface
     */
    public function setTable(CommentTableInterface $table)
    {
        $this->table = $table;
        return $this;
    }
    
    /**
     * Get config
     * 
     * @param string $key config key
     * @return array
     */
    public function getConfig($key)
    {
        if (!isset($this->config[$key])) {
            return null;
        }
        return $this->config[$key];
    }
    
    /**
     * Set config
     * 
     * @param array $config
     * @return CommentServiceInterface
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
        return $this;
    }

    /**
     * Sets comment b8Service
     *
     * @param  B8ServiceInterface $b8Service
     * @return AbstractHelper
     */
    public function setB8Service(B8ServiceInterface $b8Service = null)
    {
        $this->b8Service = $b8Service;
        return $this;
    }
    
    /**
     * Returns B8Service
     *
     * @return B8ServiceInterface
     */
    public function getB8Service()
    {
        return $this->b8Service;
    }
    
    /**
     * Get service message
     * 
     * @return array
     */
    public function getMessage()
    {
        return $this->message;
    }
    
    /**
     * Clear service message
     */
    public function clearMessage()
    {
        $this->message = null;
    }
    
    /**
     * Add service message
     * 
     * @param string new message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }
    
    /**
     * Get form with triggering the Event-Manager
     * 
     * @param  string $type form type
     * @return CommentFormInterface
     */
    public function getForm($type = 'create')
    {
        if (!isset($this->forms[$type])) {
            $this->getEventManager()->trigger(
                'set-comment-form', __CLASS__, array('type' => $type)
            );
        }
        
        return $this->forms[$type];
    }

    /**
     * Set form
     * 
     * @param CommentFormInterface $form
     * @param string $type form type
     */
    public function setForm(CommentFormInterface $form, $type = 'create')
    {
        $this->forms[$type] = $form;
    }

    /**
     * Prepare comment save form
     * 
     * @param string $url
     * @return CommentSaveForm
     */
    public function prepareCreateForm($url)
    {
        // get session container
        $namespace = new Container(self::NAMESPACE_DEFAULT);
        
        // check for form data
        if ($namespace->createForm) {
            // configure comment form
            $commentForm = $this->getForm('create');
            $commentForm->setData($namespace->createForm);
            $commentForm->isValid();
            
            // destroy form data
            $namespace->createForm = null;
            
        } else {
            // configure comment form
            $commentForm = $this->getForm('create');
            $commentForm->get('url')->setValue($url);
        }
        
        return $commentForm;
    }

    /**
     * Fetch list by url
     *
     * @param varchar $url
     * @return CommentEntityInterface[]
     */
    public function fetchListByUrl($url)
    {
        return $this->getTable('comment')->fetchListByUrl($url);
    }
    
    /**
     * Fetch count by url
     *
     * @param varchar $url
     * @return integer
     */
    public function fetchCountByUrl($url)
    {
        return $this->getTable('comment')->fetchCountByUrl($url);
    }
    
    /**
     * Fetch single by id
     *
     * @param varchar $id
     * @return CommentEntityInterface
     */
    public function fetchSingleById($id)
    {
        return $this->getTable('comment')->fetchSingleById($id);
    }
    
    /**
     * Fetch list of comments
     *
     * @param integer $page number of page
     * @return Paginator
     */
    public function fetchList($page = 1, $perPage = 4, $params = array())
    {
        // Initialize select
        $select = $this->getTable('comment')->getSql()->select();
        $select->order('cdate DESC');
        
        // loop through params
        foreach ($params as $param => $value) {
            $select->where->equalTo($param, $value);
        }
        
        // Initialize paginator
        $adapter = new DbSelect(
            $select, 
            $this->getTable('comment')->getAdapter(), 
            $this->getTable('comment')->getResultSetPrototype()
        );
        $paginator = new Paginator($adapter);
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage($perPage);
        $paginator->setPageRange(9);
        
        // return paginator
        return $paginator;
    }
    
    /**
     * Save a comment
     *
     * @param array $data input data
     * @param integer $id id of blog entry
     * @return CommentEntityInterface
     */
    public function save(array $data, $id = null)
    {
        // get session container
        $namespace = new Container(self::NAMESPACE_DEFAULT);
        
        // check mode
        $mode = is_null($id) ? 'create' : 'update';
        
        // get blog entity
        if ($mode == 'create') {
            $comment = new CommentEntity();
        } else {
            $comment = $this->fetchSingleById($id);
        }
        
        // get form and set data
        $form = $this->getForm($mode);
        $form->setData($data);
        
        // check for invalid data
        if (!$form->isValid()) {
            $this->setMessage('Bitte Eingaben überprüfen!');
            
            // save form data
            $namespace->createForm = $data;
            
            return false;
        }
        
        // get valid comment entity object
        $comment->exchangeArray($form->getData());
        
        // check spam detect
        if ($this->getConfig('spamDetect')) {
            if ($this->getB8Service()->detectSpam($comment->getFullText())) {
                $newStatus = $this->getConfig('spamStatus');
            } else {
                $newStatus = $this->getConfig('hamStatus');
            }
        } else {
            $newStatus = $this->getConfig('newStatus');
        }
        
        if ($mode == 'create') {
            // set values
            $comment->setCdate(date('Y-m-d H:i:s'));
        }
        
        // set values
        $comment->setStatus($newStatus);
        
        // get insert data
        $saveData = $comment->getArrayCopy();
        
        // insert new comment
        try {
            if ($mode == 'create') {
                $this->getTable('comment')->insert($saveData);
                
                // get last insert value
                $id = $this->getTable('comment')->getLastInsertValue();
            } else {
                $this->getTable('comment')->update($saveData, array('id' => $id));
            }
        } catch (InvalidQueryException $e) {
            $this->setMessage('Kommentar konnte nicht gespeichert werden!');
            
            // save form data
            $namespace->createForm = $data;
            
            return false;
        }

        // reload comment
        $comment = $this->fetchSingleById($id);
        
        // clear form data
        $namespace->createForm = null;
        
        // set success message
        if ($mode == 'create' && $newStatus != 'approved') {
            $this->setMessage('Kommentar wartet auf Freischaltung!');
        } else {
            $this->setMessage('Kommentar wurde gespeichert!');
        }
        
        // return comment
        return $comment;
    }
    
    /**
     * Delete existing comment
     *
     * @param integer $id comment id
     * @param array $data input data
     * @return CommentEntityInterface
     */
    public function delete($id)
    {
        // fetch comment entity
        $comment = $this->fetchSingleById($id);
        
        // delete existing comment
        try {
            $result = $this->getTable('comment')->delete(array('id' => $id));
        } catch (InvalidQueryException $e) {
            return false;
        }

        // set success message
        $this->setMessage('Der Kommentar wurde gelöscht!');
        
        // return result
        return true;
    }
    
    /**
     * Update comment status
     *
     * @param integer $id comment id
     * @param string $status new status
     * @return CommentEntityInterface
     */
    public function updateStatus($id, $status)
    {
        // fetch comment entity
        $comment = $this->fetchSingleById($id);
        $comment->setStatus($status);
        
        // get update data
        $updateData = $comment->getArrayCopy();
        
        // update existing comment
        try {
            $this->getTable('comment')->update($updateData, array('id' => $id));
        } catch (InvalidQueryException $e) {
            $this->setMessage('Kommentar konnte nicht gespeichert werden!');
            return false;
        }

        // reload comment
        $comment = $this->fetchSingleById($id);

        // set success message
        $this->setMessage('Der Status wurde geändert!');
        
        // return comment
        return $comment;
    }
}
