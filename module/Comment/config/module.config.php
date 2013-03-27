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
 * Comment module configuration
 * 
 * @package    Comment
 */
return array(
    'router' => array(
        'routes' => array(
            'comment' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/comment[/:action]',
                    'constraints' => array(
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'comment',
                        'action'     => 'index',
                    ),
                ),
            ),
            'comment-admin' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/comment-admin',
                    'defaults' => array(
                        'controller' => 'comment-admin',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'action' => array(
                        'type'    => 'segment',
                        'options' => array(
                            'route'    => '/:action[/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'     => '[0-9]+',
                            ),
                        ),
                    ),
                    'page' => array(
                        'type'    => 'segment',
                        'options' => array(
                            'route'    => '/:page[/:sort]',
                            'constraints' => array(
                                'page'   => '[0-9]+',
                                'sort'   => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    
    'controllers' => array(
        'factories' => array(
            'comment'       => 'Comment\Controller\CommentControllerFactory',
            'comment-admin' => 'Comment\Controller\AdminControllerFactory',
        ),
    ),
    
    'service_manager' => array(
        'invokables' => array(
            'Comment\Entity\Comment'  => 'Comment\Entity\CommentEntity',
        ),
        'factories' => array(
            'Comment\Table\Comment'   => 'Comment\Table\CommentTableFactory',
            'Comment\Form\Create'     => 'Comment\Form\CreateFormFactory',
            'Comment\Form\Update'     => 'Comment\Form\UpdateFormFactory',
            'Comment\Form\Delete'     => 'Comment\Form\DeleteFormFactory',
            'Comment\Service\Comment' => 'Comment\Service\CommentServiceFactory',
        ),
    ),
    
    'controller_plugins' => array(
        'factories'=> array(
            'LoadComment' => 'Comment\Controller\Plugin\LoadCommentFactory',
        ),
    ),
    
    'view_helpers' => array(
        'factories'=> array(
            'CommentShowLinks'     => 'Comment\View\Helper\CommentShowLinksFactory',
            'CommentShowComments'  => 'Comment\View\Helper\CommentShowCommentsFactory',
        ),
    ),
    
    'view_manager' => array(
        'template_map' => array(
            'widget/comments' => realpath(
                __DIR__ . '/../view/comment/widget/comments.phtml'
            ),
            'widget/links' => realpath(
                __DIR__ . '/../view/comment/widget/links.phtml'
            ),
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    
    'navigation' => array(
        'default' => array(
            'comment-admin'  => array(
                'type'       => 'mvc',
                'order'      => '800',
                'label'      => 'Kommentare',
                'route'      => 'comment-admin',
                'controller' => 'comment-admin',
                'action'     => 'index',
                'resource'   => 'comment-admin',
                'privilege'  => 'index',
                'pages'      => array(
                    'update' => array(
                        'type'       => 'mvc',
                        'label'      => 'Bearbeiten',
                        'route'      => 'comment-admin',
                        'controller' => 'comment-admin',
                        'action'     => 'update',
                    ),
                    'delete' => array(
                        'type'       => 'mvc',
                        'label'      => 'Löschen',
                        'route'      => 'comment-admin',
                        'controller' => 'comment-admin',
                        'action'     => 'delete',
                    ),
                ),
            ),
        ),
    ),
    
    'acl' => array(
        'guest'   => array(
            'comment' => array('allow' => null),
        ),
        'staff'   => array(
            'comment-admin' => array('allow' => null),
        ),
    ),
    
    'comment' => array(
        'newStatus'  => 'new',
        'spamStatus' => 'blocked',
        'hamStatus'  => 'approved',
        'spamDetect' => false,
    ),
);
