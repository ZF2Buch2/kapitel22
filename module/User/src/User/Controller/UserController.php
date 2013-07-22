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
namespace User\Controller;

use Zend\Http\PhpEnvironment\Response;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use User\Service\UserServiceInterface;

/**
 * User controller
 * 
 * Handles the user pages
 * 
 * @package    User
 */
class UserController extends AbstractActionController
{
    /**
     * @var UserServiceInterface
     */
    protected $userService;
    
    /**
     * set the user service
     * 
     * @param UserServiceInterface
     */
    public function setUserService(UserServiceInterface $userService)
    {
        $this->userService = $userService;

        return $this;
    }
    
    /**
     * Get the user service
     * 
     * @return UserServiceInterface
     */
    public function getUserService()
    {
        return $this->userService;
    }
    
    /**
     * Handle user page
     */
    public function indexAction()
    {
        // check for identity
        if (!$this->getUserService()->getAuthentication()->hasIdentity()) {
            // Redirect to login user
            return $this->redirect()->toRoute(
                'user', array('action' => 'login')
            );
        }
        
        $user = $this->getUserService()->getAuthentication()->getIdentity();
        
        return new ViewModel(array(
            'identity' => $user,
        ));
    }
    
    /**
     * Handle login page
     */
    public function loginAction()
    {
        // check for identity
        if ($this->getUserService()->getAuthentication()->hasIdentity()) {
            // Redirect to user
            return $this->redirect()->toRoute('user');
        }
        
        // prepare Post/Redirect/Get Plugin
        $prg = $this->prg(
            $this->url()->fromRoute('user', array('action' => 'login')), 
            true
        );
    
        // check PRG plugin for redirect to send
        if ($prg instanceof Response) {
            return $prg;
    
        // check PRG for redirect to process
        } elseif ($prg !== false) {
            // login with redirected data
            $user = $this->getUserService()->login($prg);
            
            // check user
            if ($user) {
                // add messages to flash messenger
                $this->flashMessenger()->addMessage(
                    $this->getUserService()->getMessage()
                );
                
                // Redirect to show user page
                return $this->redirect()->toRoute('user');
            }
        }
        
        // get form
        $form = $this->getUserService()->getForm('login');
    
        // add messages to flash messenger
        if ($this->getUserService()->getMessage()) {
            $this->flashMessenger()->addMessage(
                $this->getUserService()->getMessage()
            );
        }
        
        // no post or registration unsuccesful
        return new ViewModel(array(
            'form' => $form,
        ));
    }

    /**
     * Handle logout page
     */
    public function logoutAction()
    {
        // check for identity
        if ($this->getUserService()->getAuthentication()->hasIdentity()) {
            // logout with redirected data
            $this->getUserService()->logout();
            
            // add messages to flash messenger
            $this->flashMessenger()->addMessage(
                $this->getUserService()->getMessage()
            );
        }
        
        // Redirect to user page
        return $this->redirect()->toRoute('user');
    }

    /**
     * Handle register page
     */
    public function registerAction()
    {
        // check for identity
        if ($this->getUserService()->getAuthentication()->hasIdentity()) {
            // Redirect to user page
            return $this->redirect()->toRoute('user');
        }
        
        // prepare Post/Redirect/Get Plugin
        $prg = $this->prg(
            $this->url()->fromRoute('user', array('action' => 'register')), 
            true
        );

        // check PRG plugin for redirect to send
        if ($prg instanceof Response) {
            return $prg;
            
        // check PRG for redirect to process
        } elseif ($prg !== false) {
            // check for cancel
            if (isset($prg['cancel'])) {
                // Redirect to list of blogs
                return $this->redirect()->toRoute('user');
            }
            
            // register with redirected data
            $user = $this->getUserService()->save($prg);
            
            // check user
            if ($user) {
                // add messages to flash messenger
                $this->flashMessenger()->addMessage(
                    $this->getUserService()->getMessage()
                );
                
                // Redirect to login page
                return $this->redirect()->toRoute(
                    'user', array('action' => 'login')
                );
            }
        }
        
        // get form
        $form = $this->getUserService()->getForm('register');
        
        // add messages to flash messenger
        if ($this->getUserService()->getMessage()) {
            $this->flashMessenger()->addMessage(
                $this->getUserService()->getMessage()
            );
        }
        
        // no post or registration unsuccesful
        return new ViewModel(array(
            'form' => $form,
        ));
    }

    /**
     * Handle forbidden page
     */
    public function forbiddenAction()
    {
        $this->getResponse()->setStatusCode(Response::STATUS_CODE_403);
    }
}
