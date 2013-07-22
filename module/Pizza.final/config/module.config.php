<?php
/**
 * ZF2 Buch Kapitel 22
 * 
 * Das Buch "Zend Framework 2 - Das Praxisbuch"
 * von Ralf Eggert ist im Galileo-Computing Verlag erschienen. 
 * ISBN 978-3-8362-2610-3
 * 
 * @package    Pizza
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Alle Listings sind urheberrechtlich geschützt!
 * @link       http://www.zendframeworkbuch.de/ und http://www.galileocomputing.de/3460
 */

/**
 * Pizza module configuration
 * 
 * @package    Pizza
 */
return array(
    'router' => array(
        'routes' => array(
            'pizza' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/pizza',
                    'constraints' => array(
                    ),
                    'defaults' => array(
                        'controller' => 'pizza',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'url' => array(
                        'type'    => 'segment',
                        'options' => array(
                            'route'    => '/:url',
                            'constraints' => array(
                                'url' => '[a-zA-Z][a-zA-Z0-9-]*',
                            ),
                            'defaults' => array(
                                'action'     => 'show',
                            ),
                        ),
                    ),
                    'basket' => array(
                        'type'    => 'segment',
                        'options' => array(
                            'route'    => '/basket[/:id]',
                            'constraints' => array(
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'action'     => 'basket',
                            ),
                        ),
                    ),
                    'page' => array(
                        'type'    => 'segment',
                        'options' => array(
                            'route'    => '/:page',
                            'constraints' => array(
                                'page'   => '[0-9]+',
                            ),
                        ),
                    ),
                ),
            ),
            'pizza-admin' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/pizza-admin',
                    'defaults' => array(
                        'controller' => 'pizza-admin',
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
            'pizza'       => 'Pizza\Controller\PizzaControllerFactory',
            'pizza-admin' => 'Pizza\Controller\AdminControllerFactory',
        ),
    ),
    
    'service_manager' => array(
        'invokables' => array(
            'Pizza\Entity\Crust'       => 'Pizza\Entity\CrustEntity',
            'Pizza\Entity\Pizza'       => 'Pizza\Entity\PizzaEntity',
            'Pizza\Entity\Topping'     => 'Pizza\Entity\ToppingEntity',
        ),
        'factories' => array(
            'Pizza\Table\Crust'        => 'Pizza\Table\CrustTableFactory',
            'Pizza\Table\Pizza'        => 'Pizza\Table\PizzaTableFactory',
            'Pizza\Table\PizzaTopping' => 'Pizza\Table\PizzaToppingTableFactory',
            'Pizza\Table\Topping'      => 'Pizza\Table\ToppingTableFactory',
            'Pizza\Form\Create'        => 'Pizza\Form\CreateFormFactory',
            'Pizza\Form\Update'        => 'Pizza\Form\UpdateFormFactory',
            'Pizza\Form\Delete'        => 'Pizza\Form\DeleteFormFactory',
            'Pizza\Service\Pizza'      => 'Pizza\Service\PizzaServiceFactory',
        ),
    ),
    
    'input_filters' => array(
        'invokables' => array(
            'Pizza\Filter\Pizza'   => 'Pizza\Filter\PizzaFilter',
        ),
    ),
    
    'view_helpers' => array(
        'factories'=> array(
            'PizzaShowCarousel' => 'Pizza\View\Helper\PizzaShowCarouselFactory',
        ),
        'invokables'=> array(
            'PizzaShowToppings' => 'Pizza\View\Helper\PizzaShowToppings',
            'PizzaShowPicture'  => 'Pizza\View\Helper\PizzaShowPicture',
        ),
    ),
    
    'view_manager' => array(
        'template_map' => array(
            'widget/carousel' => realpath(__DIR__ . '/../view/pizza/widget/carousel.phtml'),
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    
    'navigation' => array(
        'default' => array(
            'pizza' => array(
                'type'       => 'mvc',
                'order'      => '100',
                'label'      => 'Pizza',
                'route'      => 'pizza',
                'controller' => 'pizza',
                'action'     => 'index',
                'pages'      => array(
                    'show' => array(
                        'type'       => 'mvc',
                        'label'      => 'Anzeigen',
                        'route'      => 'pizza',
                        'controller' => 'pizza',
                        'action'     => 'show',
                    ),
                    'pizza-admin' => array(
                        'type'       => 'mvc',
                        'label'      => 'Pizzaverwaltung',
                        'route'      => 'pizza-admin',
                        'controller' => 'pizza-admin',
                        'action'     => 'index',
                    ),
                    'create' => array(
                        'type'       => 'mvc',
                        'label'      => 'Anlegen',
                        'route'      => 'pizza-admin',
                        'controller' => 'pizza-admin',
                        'action'     => 'create',
                    ),
                    'update' => array(
                        'type'       => 'mvc',
                        'label'      => 'Bearbeiten',
                        'route'      => 'pizza-admin',
                        'controller' => 'pizza-admin',
                        'action'     => 'update',
                    ),
                    'delete' => array(
                        'type'       => 'mvc',
                        'label'      => 'Löschen',
                        'route'      => 'pizza-admin',
                        'controller' => 'pizza-admin',
                        'action'     => 'delete',
                    ),
                ),
            ),
        ),
    ),
    
    'acl' => array(
        'guest'   => array(
            'pizza' => array('allow' => null),
        ),
        'staff'   => array(
            'pizza-admin' => array('allow' => null),
        ),
    ),
);
