<?php
/**
 * ZF2 Buch Kapitel 22
 * 
 * Das Buch "Zend Framework 2 - Von den Grundlagen bis zur fertigen Anwendung"
 * von Ralf Eggert ist im Addison-Wesley Verlag erschienen. 
 * ISBN 978-3-8273-2994-3
 * 
 * @package    Shop
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Alle Listings sind urheberrechtlich geschützt!
 * @link       http://www.zendframeworkbuch.de/ und http://www.awl.de/2994
 */

/**
 * namespace definition and usage
 */
namespace Shop\Entity;

use User\Entity\UserEntityInterface;
use Zend\Filter\StaticFilter;

/**
 * Shop entity
 * 
 * @package    Shop
 */
class OrderEntity implements OrderEntityInterface
{
    protected $statusNames = array(
        'new'      => 'neu',
        'canceled' => 'storniert',
        'sent'     => 'versandt',
    );
    
    protected $id;
    protected $cdate;
    protected $status;
    protected $positions;
    protected $comments;
    protected $userId;
    protected $identity;
    
    /**
     * Set id
     * 
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * Get id
     * 
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set cdate
     * 
     * @param string $cdate
     */
    public function setCdate($cdate)
    {
        $this->cdate = $cdate;
    }
    
    /**
     * Get cdate
     * 
     * @return string $cdate
     */
    public function getCdate()
    {
        return $this->cdate;
    }
    
    /**
     * Set status
     * 
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
    
    /**
     * Get status
     * 
     * @return string $status
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * Get status name
     * 
     * @return string $status
     */
    public function getStatusName()
    {
        return $this->statusNames[$this->status];
    }
    
    /**
     * Get status names
     * 
     * @return array list of stati
     */
    public function getStatusNames()
    {
        return $this->statusNames;
    }
    
    /**
     * Set positions
     * 
     * @param string $positions
     */
    public function setPositions($positions)
    {
        $this->positions = $positions;
    }
    
    /**
     * Get positions
     * 
     * @return string $positions
     */
    public function getPositions()
    {
        return $this->positions;
    }
    
    /**
     * Set comments
     * 
     * @param string $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }
    
    /**
     * Get comments
     * 
     * @return string $comments
     */
    public function getComments()
    {
        return $this->comments;
    }
    
    /**
     * Set userId
     * 
     * @param string $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }
    
    /**
     * Get userId
     * 
     * @return string $userId
     */
    public function getUserId()
    {
        return $this->userId;
    }
    
    /**
     * Set identity
     * 
     * @param UserEntityInterface $identity
     */
    public function setIdentity(UserEntityInterface $identity)
    {
        $this->identity = $identity;
    }
    
    /**
     * Get identity
     * 
     * @return UserEntityInterface $identity
     */
    public function getIdentity()
    {
        return $this->identity;
    }
    
    /**
     * Exchange internal values from provided array
     *
     * @param  array $array
     * @return void
     */
    public function exchangeArray(array $array)
    {
        foreach ($array as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $method = 'set' . StaticFilter::execute(
                $key, 'wordunderscoretocamelcase'
            );
            if (!method_exists($this, $method)) {
                continue;
            }
            $this->$method($value);
        }
    }

    /**
     * Return an array representation of the object
     *
     * @return array
     */
    public function getArrayCopy()
    {
        return array(
            'id'        => $this->getId(),
            'cdate'     => $this->getCdate(),
            'status'    => $this->getStatus(),
            'positions' => $this->getPositions(),
            'comments'  => $this->getComments(),
            'user_id'    => $this->getUserId(),
        );
    }
}
