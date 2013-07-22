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
namespace Comment\View\Helper;

use Comment\Service\CommentServiceInterface;
use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;

/**
 * Show comment links view helper
 * 
 * Outputs the comment links for a given url
 * 
 * @package    Comment
 */
class CommentShowLinks extends AbstractHelper
{
    /**
     * @var CommentServiceInterface
     */
    protected $commentService;

    /**
     * Constructor
     *
     * @param  CommentServiceInterface $commentService
     */
    public function __construct(CommentServiceInterface $commentService)
    {
        $this->setCommentService($commentService);
    }

    /**
     * Sets comment commentService
     *
     * @param  CommentServiceInterface $commentService
     * @return AbstractHelper
     */
    public function setCommentService(CommentServiceInterface $commentService = null)
    {
        $this->commentService = $commentService;
        return $this;
    }
    
    /**
     * Returns CommentService
     *
     * @return CommentServiceInterface
     */
    public function getCommentService()
    {
        return $this->commentService;
    }
    
    /**
     * Outputs the comment list in a carousel
     *
     * @return string 
     */
    public function __invoke($url)
    {
        // configure view model
        $vm = new ViewModel(array(
            'commentUrl'   => $url,
            'commentCount' => $this->getCommentService()->fetchCountByUrl($url)
        ));
        $vm->setTemplate('widget/links');
        
        // render view
        return $this->getView()->render($vm);
    }
}
