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
 * User module configuration
 * 
 * @package    User
 */
return array(
    'router' => array(
        'routes' => array(
            'user' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/user[/:action]',
                    'constraints' => array(
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'user',
                        'action'     => 'index',
                    ),
                ),
            ),
            'user-admin' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/user-admin',
                    'defaults' => array(
                        'controller' => 'user-admin',
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
            'user'       => 'User\Controller\UserControllerFactory',
            'user-admin' => 'User\Controller\AdminControllerFactory',
        ),
    ),
    
    'input_filters' => array(
        'invokables' => array(
            'User\Filter\User'   => 'User\Filter\UserFilter',
        ),
    ),
    
    'service_manager' => array(
        'invokables' => array(
            'User\Entity\User'   => 'User\Entity\UserEntity',
        ),
        'factories' => array(
            'User\Table\User'    => 'User\Table\UserTableFactory',
            'User\Form\Register' => 'User\Form\RegisterFormFactory',
            'User\Form\Update'   => 'User\Form\UpdateFormFactory',
            'User\Form\Delete'   => 'User\Form\DeleteFormFactory',
            'User\Form\Login'    => 'User\Form\LoginFormFactory',
            'User\Form\Logout'   => 'User\Form\LogoutFormFactory',
            'User\Acl\Service'   => 'User\Acl\ServiceFactory',
            'User\Auth\Adapter'  => 'User\Authentication\DbBcryptAdapterFactory',
            'User\Auth\Service'  => 'User\Authentication\ServiceFactory',
            'User\Service\User'  => 'User\Service\UserServiceFactory',
        ),
    ),
    
    'view_helpers' => array(
        'factories'=> array(
            'UserShowWidget' => 'User\View\Helper\UserShowWidgetFactory',
            'UserIsAllowed'  => 'User\View\Helper\UserIsAllowedFactory',
        ),
    ),
    
    'view_manager' => array(
        'template_map' => array(
            'widget/logout' => realpath(__DIR__ . '/../view/user/widget/logout.phtml'),
            'widget/login'  => realpath(__DIR__ . '/../view/user/widget/login.phtml'),
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    
    'navigation' => array(
        'default' => array(
            'user' => array(
                'type'       => 'mvc',
                'order'      => '700',
                'label'      => 'Benutzer',
                'route'      => 'user',
                'controller' => 'user',
                'action'     => 'index',
                'pages'      => array(
                    'register' => array(
                        'type'       => 'mvc',
                        'label'      => 'Registrieren',
                        'route'      => 'user',
                        'controller' => 'user',
                        'action'     => 'register',
                    ),
                    'login' => array(
                        'type'       => 'mvc',
                        'label'      => 'Anmelden',
                        'route'      => 'user',
                        'controller' => 'user',
                        'action'     => 'login',
                    ),
                    'user-admin' => array(
                        'type'       => 'mvc',
                        'label'      => 'Benutzerverwaltung',
                        'route'      => 'user-admin',
                        'controller' => 'user-admin',
                        'action'     => 'index',
                    ),
                    'update' => array(
                        'type'       => 'mvc',
                        'label'      => 'Bearbeiten',
                        'visible'    => false,
                        'route'      => 'user-admin',
                        'controller' => 'user-admin',
                        'action'     => 'update',
                    ),
                    'delete' => array(
                        'type'       => 'mvc',
                        'label'      => 'Löschen',
                        'visible'    => false,
                        'route'      => 'user-admin',
                        'controller' => 'user-admin',
                        'action'     => 'delete',
                    ),
                ),
            ),
        ),
    ),
    
    'acl' => array(
        'guest'   => array(
            'user' => array(
                'allow' => null,
                'deny'  => array('logout', 'update'),
            ),
        ),
        'customer' => array(
            'user' => array(
                'allow' => null,
                'deny'  => array('login', 'register'),
            ),
        ),
        'admin'   => array(
            'user'       => array('allow' => null),
            'user-admin' => array('allow' => null),
        ),
    ),
);
