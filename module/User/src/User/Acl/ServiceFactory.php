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
namespace User\Acl;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Create ACL factory
 * 
 * @package    User
 */
class ServiceFactory implements FactoryInterface
{
    /**
     * Create Service Factory
     * 
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $auth   = $serviceLocator->get('User\Auth\Service');
        $role   = $auth->hasIdentity() 
                ? $auth->getIdentity()->getRole() 
                : 'guest';
        $acl    = new Service($role, $config['acl']);
        return $acl;
    }
}
