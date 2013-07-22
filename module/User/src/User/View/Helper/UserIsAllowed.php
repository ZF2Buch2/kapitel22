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
namespace User\View\Helper;

use Zend\View\Helper\AbstractHelper;
use User\Acl\Service as AclService;

/**
 * User is allowed view helper
 * 
 * Checks if a user is allowed to access
 * 
 * @package    User
 */
class UserIsAllowed extends AbstractHelper
{
    /**
     * Acl Service
     *
     * @var AclService
     */
    protected $acl;

    /**
     * Constructor
     *
     * @param  AclService $acl
     */
    public function __construct(AclService $acl)
    {
        $this->setAcl($acl);
    }

    /**
     * Sets AclService
     *
     * @param  AclService $acl
     * @return AbstractHelper
     */
    public function setAcl(AclService $acl = null)
    {
        $this->acl = $acl;
        return $this;
    }
    
    /**
     * Returns AclService
     *
     * @return AclService
     */
    public function getAcl()
    {
        return $this->acl;
    }
    
    /**
     * Checks if current role is allowed to access resource with privilege
     *
     * @return boolean
     */
    public function __invoke($resource, $privilege = 'index')
    {
        return $this->getAcl()->isAllowed($resource, $privilege);
    }
}