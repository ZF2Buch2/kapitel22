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
namespace Comment\Entity;

use Zend\Filter\StaticFilter;

/**
 * Comment entity
 * 
 * @package    Comment
 */
class CommentEntity implements CommentEntityInterface
{
    protected $statusNames = array(
        'new'      => 'neu',
        'blocked'  => 'gesperrt',
        'approved' => 'genehmigt',
    );
    
    protected $id;
    protected $cdate;
    protected $status;
    protected $url;
    protected $email;
    protected $name;
    protected $message;
    
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
     * Set url
     * 
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }
    
    /**
     * Get url
     * 
     * @return string $url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
    
    /**
     * Get email
     *
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * Set name
     * 
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * Get name
     * 
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Set message
     * 
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }
    
    /**
     * Get message
     * 
     * @return string $message
     */
    public function getMessage()
    {
        return $this->message;
    }
    
    /**
     * Get full text
     * 
     * @return string full text
     */
    public function getFullText()
    {
        return strip_tags(implode("\n", array(
            $this->getName(),
            $this->getEmail(),
            $this->getMessage(),
        )));
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
            'id'       => $this->getId(),
            'cdate'    => $this->getCdate(),
            'status'   => $this->getStatus(),
            'url'      => $this->getUrl(),
            'email'    => $this->getEmail(),
            'name'     => $this->getName(),
            'message'  => $this->getMessage(),
        );
    }
}
