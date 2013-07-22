<?php
/**
 * ZF2 Buch Kapitel 22
 * 
 * Das Buch "Zend Framework 2 - Das Praxisbuch"
 * von Ralf Eggert ist im Galileo-Computing Verlag erschienen. 
 * ISBN 978-3-8362-2610-3
 * 
 * @package    Pizza
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Alle Listings sind urheberrechtlich geschützt!
 * @link       http://www.zendframeworkbuch.de/ und http://www.galileocomputing.de/3460
 */

/**
 * namespace definition and usage
 */
namespace Pizza\Service;

use Zend\Db\Adapter\Exception\InvalidQueryException;
use Zend\Db\TableGateway\TableGateway;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\Filter\StaticFilter;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect;
use Pizza\Entity\PizzaEntityInterface;
use Pizza\Entity\PizzaEntity;
use Pizza\Form\PizzaFormInterface;
use Pizza\Table\PizzaTableInterface;

/**
 * Pizza Service
 * 
 * @package    Pizza
 */
class PizzaService implements EventManagerAwareInterface, PizzaServiceInterface
{
    /**
     * @var EventManagerInterface
     */
    protected $eventManager = null;
    
    /**
     * @var PizzaFormInterface[]
     */
    protected $forms = array();

    /**
     * @var TableGateway[]
     */
    protected $tables = array();

    /**
     * @var string
     */
    protected $message = null;
    
    /**
     * Constructor
     * 
     * @param PizzaTableInterface $pizzaTable
     */
    public function __construct(PizzaTableInterface $pizzaTable)
    {
        $this->setTable($pizzaTable, 'pizza');
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
     * Get table with triggering the Event-Manager
     * 
     * @param  string $type table type
     * @return TableGateway
     */
    public function getTable($type = 'pizza')
    {
        if (!isset($this->tables[$type])) {
            $this->getEventManager()->trigger(
                'set-pizza-table', __CLASS__, array('type' => $type)
            );
        }
        
        return $this->tables[$type];
    }

    /**
     * Set table
     * 
     * @param TableGateway $table
     * @param string $type table type
     */
    public function setTable(TableGateway $table, $type = 'pizza')
    {
        $this->tables[$type] = $table;
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
     * @return PizzaFormInterface
     */
    public function getForm($type = 'create')
    {
        if (!isset($this->forms[$type])) {
            $this->getEventManager()->trigger(
                'set-pizza-form', __CLASS__, array('type' => $type)
            );
        }
        
        return $this->forms[$type];
    }

    /**
     * Set form
     * 
     * @param PizzaFormInterface $form
     * @param string $type form type
     */
    public function setForm(PizzaFormInterface $form, $type = 'create')
    {
        $this->forms[$type] = $form;
    }

    /**
     * Add crust and toppings
     *
     * @param PizzaEntityInterface $pizza
     * @return PizzaEntityInterface
     */
    public function addCrustAndToppings($pizza)
    {
        $pizza->setCrustEntity(
            $this->getTable('crust')->fetchSingleById($pizza->getCrustId())
        );
        $pizza->setToppings(
            $this->getTable('topping')->fetchListByPizzaId($pizza->getId())
        );
        
        return $pizza;
    }
    
    /**
     * Fetch single by url
     *
     * @param varchar $url
     * @return PizzaEntityInterface
     */
    public function fetchSingleByUrl($url)
    {
        $pizza = $this->getTable('pizza')->fetchSingleByUrl($url);
        $pizza = $this->addCrustAndToppings($pizza);
        
        return $pizza;
    }
    
    /**
     * Fetch single by id
     *
     * @param varchar $id
     * @return PizzaEntityInterface
     */
    public function fetchSingleById($id)
    {
        $pizza = $this->getTable('pizza')->fetchSingleById($id);
        $pizza = $this->addCrustAndToppings($pizza);
        
        return $pizza;
    }
    
    /**
     * Fetch list of pizzas
     *
     * @param integer $page number of page
     * @return Paginator
     */
    public function fetchList($page = 1, $perPage = 4, $params = array())
    {
        // Initialize select
        $select = $this->getTable('pizza')->getSql()->select();
        $select->order('url ASC');
        
        // loop through params
        foreach ($params as $param => $value) {
            $select->where->equalTo($param, $value);
        }
        
        // Initialize paginator
        $adapter = new DbSelect(
            $select, 
            $this->getTable('pizza')->getAdapter(), 
            $this->getTable('pizza')->getResultSetPrototype()
        );
        $paginator = new Paginator($adapter);
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage($perPage);
        $paginator->setPageRange(9);
        
        // return paginator
        return $paginator;
    }
    
    /**
     * Save a pizza
     *
     * @param array $data input data
     * @param integer $id id of pizza entry
     * @return BlogEntityInterface
     */
    public function save(array $data, $id = null)
    {
        // check mode
        $mode = is_null($id) ? 'create' : 'update';
        
        // create new pizza entity
        if ($mode == 'create') {
            $pizza = new PizzaEntity();
        } else {
            $pizza = $this->fetchSingleById($id);
        }
        
        // get toppings
        if ($mode == 'create') {
            $currentToppings = array();
        } else {
            $currentToppings = array_keys($pizza->getToppings());
        }
        $newToppings = $data['toppings'];
        
        // get form and set data
        $form = $this->getForm($mode);
        $form->setData($data);
        
        // check for invalid data
        if (!$form->isValid()) {
            $this->setMessage('Bitte Eingaben überprüfen!');
            return false;
        }
        
        // check for invalid upload
        if ($mode == 'update' && $form->get('picture')->getMessages()) {
            $this->setMessage('Bitte Eingaben überprüfen!');
            return false;
        }
        
        // get form data
        $formData = $form->getData();
        
        // handle upload
        if ($mode == 'update') {
            // set file names
            $oldFile = $formData['picture']['tmp_name'];
            $newFile = LUIGI_ROOT . '/public/img/uploads/pizza' . $id . '.jpg';
            
            // check old file, copy and delete it
            if (file_exists($oldFile)) {
                if (copy($oldFile, $newFile)) {
                    unlink($oldFile);
                }
            }
        }
        
        // get valid pizza entity object
        $pizza->exchangeArray($formData);
        
        // set values
        $pizza->setUrl(StaticFilter::execute($pizza->getName(), 'StringToUrl'));
        
        // get insert data
        $saveData = $pizza->getArrayCopy();
        
        // insert new pizza
        try {
            if ($mode == 'create') {
                $this->getTable('pizza')->insert($saveData);
                
                // get last insert value
                $id = $this->getTable('pizza')->getLastInsertValue();
            } else {
                $this->getTable('pizza')->update($saveData, array('id' => $id));
            }
        } catch (InvalidQueryException $e) {
            $this->setMessage('Pizza konnte nicht gespeichert werden!');
            return false;
        }

        // save toppings
        $this->getTable('pizza_topping')->savePizzaToppings(
            $id, $currentToppings, $newToppings
        );
        
        // reload pizza
        $pizza = $this->fetchSingleById($id);
        
        // set success message
        $this->setMessage('Die Pizza wurde gespeichert!');
        
        // return pizza
        return $pizza;
    }
    
    /**
     * Delete existing pizza
     *
     * @param integer $id pizza id
     * @param array $data input data
     * @return PizzaEntityInterface
     */
    public function delete($id)
    {
        // fetch pizza entity
        $pizza = $this->fetchSingleById($id);
        
        // delete existing pizza
        try {
            $result = $this->getTable('pizza')->delete(array('id' => $id));
        } catch (InvalidQueryException $e) {
            return false;
        }

        // set success message
        $this->setMessage('Die Pizza wurde gelöscht!');
        
        // return result
        return true;
    }
}
