<?php
/**
 * ZF2 Buch Kapitel 22
 * 
 * Das Buch "Zend Framework 2 - Von den Grundlagen bis zur fertigen Anwendung"
 * von Ralf Eggert ist im Addison-Wesley Verlag erschienen. 
 * ISBN 978-3-8273-2994-3
 * 
 * @package    Comment
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Alle Listings sind urheberrechtlich geschützt!
 * @link       http://www.zendframeworkbuch.de/ und http://www.awl.de/2994
 */

/**
 * namespace definition and usage
 */
namespace Comment\Controller;

use Zend\Http\PhpEnvironment\Response;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use Comment\Service\CommentServiceInterface;

/**
 * Admin controller
 * 
 * Handles the admin pages
 * 
 * @package    Comment
 */
class AdminController extends AbstractActionController
{
    /**
     * @var CommentServiceInterface
     */
    protected $commentService;
    
    /**
     * set the comment service
     *
     * @param CommentServiceInterface
     */
    public function setCommentService(CommentServiceInterface $commentService)
    {
        $this->commentService = $commentService;
    
        return $this;
    }
    
    /**
     * Get the comment service
     *
     * @return CommentServiceInterface
     */
    public function getCommentService()
    {
        return $this->commentService;
    }
    
    /**
     * Handle admin page
     */
    public function indexAction()
    {
        // read page from route
        $page = (int) $this->params()->fromRoute('page');
        
        // set max comment per page
        $maxPage = 10;
        
        // read data and pass to view
        return new ViewModel(array(
            'commentList' => $this->getCommentService()->fetchList($page, $maxPage),
        ));
    }
    
    /**
     * Handle show page
     */
    public function showAction()
    {
        // load comment
        if (!$comment = $this->loadComment()) {
            return $this->getResponse();
        }
        
        // pass comment to view
        return new ViewModel(array(
            'comment' => $comment,
        ));
    }
    
    /**
     * Handle update page
     */
    public function updateAction()
    {
        // load comment
        if (!$comment = $this->loadComment()) {
            return $this->getResponse();
        }
        
        // prepare Post/Redirect/Get Plugin
        $prg = $this->prg(
            $this->url()->fromRoute('comment-admin/action', array(), array(), true), 
            true
        );
        
        // check PRG plugin for redirect to send
        if ($prg instanceof Response) {
            return $prg;
            
        // check PRG for redirect to process
        } elseif ($prg !== false) {
            // check for cancel
            if (isset($prg['cancel'])) {
                // Redirect to list of comments
                return $this->redirect()->toRoute('comment-admin');
            }
            
            // update with redirected data
            $comment = $this->getCommentService()->save($prg, $comment->getId());
            
            // check comment
            if ($comment) {
                // add messages to flash messenger
                $this->flashMessenger()->addMessage(
                    $this->getCommentService()->getMessage()
                );
                
                // Redirect to update comment
                return $this->redirect()->toRoute(
                    'comment-admin/action', array(), array(), true
                );
            }
        }
        
        // get form and bind object
        $form = $this->getCommentService()->getForm('update');
        
        //check prg
        if ($prg === false) {
            $form->bind($comment);
        }
        
        // add messages to flash messenger
        if ($this->getCommentService()->getMessage()) {
            $this->flashMessenger()->addMessage(
                $this->getCommentService()->getMessage()
            );
        }
        
        // no post or update unsuccesful
        return new ViewModel(array(
            'form' => $form,
            'comment' => $comment,
        ));
    }
    
    /**
     * Handle delete page
     */
    public function deleteAction()
    {
        // load comment
        if (!$comment = $this->loadComment()) {
            return $this->getResponse();
        }
        
        // prepare Post/Redirect/Get Plugin
        $prg = $this->prg(
            $this->url()->fromRoute('comment-admin/action', array(), array(), true), 
            true
        );
        
        // check PRG plugin for redirect to send
        if ($prg instanceof Response) {
            return $prg;
            
        // check PRG for redirect to process
        } elseif ($prg !== false) {
            // check for cancel
            if (isset($prg['cancel'])) {
                // Redirect to list of comments
                return $this->redirect()->toRoute('comment-admin');
            }
            
            // delete with redirected data
            $comment = $this->getCommentService()->delete($comment->getId());
            
            // check comment
            if ($comment) {
                // add messages to flash messenger
                $this->flashMessenger()->addMessage(
                    $this->getCommentService()->getMessage()
                );
                
                // Redirect to list of comment
                return $this->redirect()->toRoute('comment-admin');
            }
        }
        
        // get form and bind object
        $form = $this->getCommentService()->getForm('delete');
        
        //check prg
        if ($prg === false) {
            $form->bind($comment);
        }
        
        // add messages to flash messenger
        if ($this->getCommentService()->getMessage()) {
            $this->flashMessenger()->addMessage(
                $this->getCommentService()->getMessage()
            );
        }
        
        // no post or update unsuccesful
        return new ViewModel(array(
            'form' => $form,
            'comment' => $comment,
        ));
    }
    
    /**
     * Handle spam page
     */
    public function spamAction()
    {
        // load comment
        if (!$comment = $this->loadComment()) {
            return $this->getResponse();
        }
        
        // mark as spam
        $this->spamCheck()->markAsSpam($comment->getFullText());
        
        // change status
        $this->getCommentService()->updateStatus($comment->getId(), 'blocked');
        
        // redirect
        return $this->redirect()->toRoute('comment-admin/action', array(
            'action' => 'show', 'id' => $comment->getId())
        );
    }
    
    /**
     * Handle ham page
     */
    public function hamAction()
    {
        // load comment
        if (!$comment = $this->loadComment()) {
            return $this->getResponse();
        }
        
        // mark as ham
        $this->spamCheck()->markAsHam($comment->getFullText());
        
        // change status
        $this->getCommentService()->updateStatus($comment->getId(), 'approved');
        
        // redirect
        return $this->redirect()->toRoute('comment-admin/action', array(
            'action' => 'show', 'id' => $comment->getId())
        );
    }
    
    /**
     * Handle no-spam page
     */
    public function noSpamAction()
    {
        // load comment
        if (!$comment = $this->loadComment()) {
            return $this->getResponse();
        }
        
        // mark as no spam
        $this->spamCheck()->markAsNoSpam($comment->getFullText());
    
        // change status
        $this->getCommentService()->updateStatus($comment->getId(), 'new');
    
        // redirect
        return $this->redirect()->toRoute('comment-admin/action', array(
            'action' => 'show', 'id' => $comment->getId())
        );
    }
    
    /**
     * Handle no-ham page
     */
    public function noHamAction()
    {
        // load comment
        if (!$comment = $this->loadComment()) {
            return $this->getResponse();
        }
        
        // mark as no ham
        $this->spamCheck()->markAsNoHam($comment->getFullText());
    
        // change status
        $this->getCommentService()->updateStatus($comment->getId(), 'new');
    
        // redirect
        return $this->redirect()->toRoute('comment-admin/action', array(
            'action' => 'show', 'id' => $comment->getId())
        );
    }
}
