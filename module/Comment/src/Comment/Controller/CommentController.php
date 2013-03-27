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

use Zend\View\Model\ViewModel;
use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Comment\Service\CommentServiceInterface;

/**
 * Comment controller
 * 
 * Handles the comment pages
 * 
 * @package    Comment
 */
class CommentController extends AbstractActionController
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
     * Handle comment page
     */
    public function indexAction()
    {
        // Redirect to home page
        return $this->redirect()->toRoute('home');
    }
    
    /**
     * Handle add page
     */
    public function addAction()
    {
        // prepare Post/Redirect/Get Plugin
        $prg = $this->prg(
            $this->url()->fromRoute(
                'comment/action', array('action' => 'add')
            ), 
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
                return $this->redirect()->toUrl($prg['url']);
            }
            
            // create with redirected data
            $comment = $this->getCommentService()->save($prg);
            
            // check comment
            if ($comment) {
                // add messages to flash messenger
                $this->flashMessenger()->addMessage(
                    $this->getCommentService()->getMessage()
                );
                
                // Redirect to home page
                return $this->redirect()->toUrl(
                    $comment->getUrl() . '#comment-' . $comment->getId()
                );
            }
        }
        
        // check for direct access to action
        if ($prg === false) {
            // Redirect to home page
            return $this->redirect()->toRoute('home');
        }
        
        // Redirect to list of comment
        return $this->redirect()->toUrl($prg['url'] . '#comment-form');
    }
}
