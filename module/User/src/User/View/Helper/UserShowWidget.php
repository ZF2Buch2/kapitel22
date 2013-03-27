<?php
/**
 * ZF2 Buch Kapitel 22
 * 
 * Das Buch "Zend Framework 2 - Von den Grundlagen bis zur fertigen Anwendung"
 * von Ralf Eggert ist im Addison-Wesley Verlag erschienen. 
 * ISBN 978-3-8273-2994-3
 * 
 * @package    User
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Alle Listings sind urheberrechtlich geschützt!
 * @link       http://www.zendframeworkbuch.de/ und http://www.awl.de/2994
 */

/**
 * namespace definition and usage
 */
namespace User\View\Helper;

use User\Entity\UserEntityInterface;
use User\Service\UserServiceInterface;
use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;

/**
 * Show user widget view helper
 * 
 * Outputs a user widget depending on login status
 * 
 * @package    User
 */
class UserShowWidget extends AbstractHelper
{
    /**
     * @var UserEntityInterface
     */
    protected $identity;

    /**
     * @var UserServiceInterface
     */
    protected $userService;

    /**
     * Constructor
     *
     * @param  UserEntityInterface $identity
     */
    public function __construct(
        UserEntityInterface $identity = null, 
        UserServiceInterface $userService
    ) {
        $this->setIdentity($identity);
        $this->setUserService($userService);
    }

    /**
     * Sets UserEntityInterface
     *
     * @param  UserEntityInterface $identity
     * @return AbstractHelper
     */
    public function setIdentity(UserEntityInterface $identity = null)
    {
        $this->identity = $identity;
        return $this;
    }
    
    /**
     * Returns UserEntityInterface
     *
     * @return UserEntityInterface
     */
    public function getIdentity()
    {
        return $this->identity;
    }
    
    /**
     * Sets user service
     *
     * @param  UserServiceInterface $userService
     * @return AbstractHelper
     */
    public function setUserService(UserServiceInterface $userService = null)
    {
        $this->userService = $userService;
        return $this;
    }
    
    /**
     * Returns UserService
     *
     * @return UserServiceInterface
     */
    public function getUserService()
    {
        return $this->userService;
    }
    
    /**
     * Outputs user widget depending on login status
     *
     * @return string 
     */
    public function __invoke()
    {
        // check login
        if ($this->getIdentity()) {
            return $this->buildLogoutWidget() . "\n";
        } else {
            return $this->buildLoginWidget() . "\n";
        }
    }
    
    /**
     * Build login widget
     *
     * @return string
     */
    public function buildLoginWidget()
    {
        // check url
        if (   $this->getView()->url('user/action', array(), array(), true) 
            == $this->getView()->url('user/action', array('action' => 'login'))) 
        {
            return '';
        }
        
        $vm = new ViewModel(array(
            'form' => $this->getUserService()->getForm('login'),
        ));
        $vm->setTemplate('widget/login');
        
        return $this->getView()->render($vm);
    }
    
    /**
     * Build logout widget
     *
     * @return string
     */
    public function buildLogoutWidget()
    {
        $vm = new ViewModel(array(
            'form'     => $this->getUserService()->getForm('logout'),
            'identity' => $this->getIdentity(),
        ));
        $vm->setTemplate('widget/logout');
        
        return $this->getView()->render($vm);
    }
}
