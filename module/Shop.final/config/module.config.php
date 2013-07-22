<?php
/**
 * ZF2 Buch Kapitel 22
 * 
 * Das Buch "Zend Framework 2 - Das Praxisbuch"
 * von Ralf Eggert ist im Galileo-Computing Verlag erschienen. 
 * ISBN 978-3-8362-2610-3
 * 
 * @package    Shop
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Alle Listings sind urheberrechtlich geschützt!
 * @link       http://www.zendframeworkbuch.de/ und http://www.galileocomputing.de/3460
 */

/**
 * Shop module configuration
 * 
 * @package    Shop
 */
return array(
    'router' => array(
        'routes' => array(
            'shop' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/shop',
                    'defaults' => array(
                        'controller' => 'basket',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'basket' => array(
                        'type'    => 'segment',
                        'options' => array(
                            'route'    => '/basket[/:action[/:id]]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9-]*',
                                'id'     => '[0-9]+',
                            ),
                        ),
                    ),
                    'order' => array(
                        'type'    => 'literal',
                        'options' => array(
                            'route'    => '/order',
                            'defaults' => array(
                                'controller' => 'order',
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
        ),
    ),
    
    'controllers' => array(
        'factories' => array(
            'basket' => 'Shop\Controller\BasketControllerFactory',
            'order'  => 'Shop\Controller\OrderControllerFactory',
        ),
    ),
    
    'service_manager' => array(
        'invokables' => array(
            'Shop\Entity\Basket'   => 'Shop\Entity\BasketEntity',
            'Shop\Entity\Order'    => 'Shop\Entity\OrderEntity',
            'Shop\Entity\Position' => 'Shop\Entity\PositionEntity',
            'Shop\Service\Basket'  => 'Shop\Service\BasketService',
        ),
        'factories' => array(
            'Shop\Table\Order'    => 'Shop\Table\OrderTableFactory',
            'Shop\Form\Create'    => 'Shop\Form\CreateFormFactory',
            'Shop\Form\Update'    => 'Shop\Form\UpdateFormFactory',
            'Shop\Form\Delete'    => 'Shop\Form\DeleteFormFactory',
            'Shop\Service\Order'  => 'Shop\Service\OrderServiceFactory',
        ),
    ),
    
    'controller_plugins' => array(
        'factories'=> array(
            'ShopBasket' => 'Shop\Controller\Plugin\BasketFactory',
        ),
    ),
    
    'input_filters' => array(
        'invokables' => array(
            'Shop\Filter\Order'   => 'Shop\Filter\OrderFilter',
        ),
    ),
    
    'hydrators' => array(
        'invokables' => array(
            'Shop\Hydrator\Order'   => 'Shop\Hydrator\OrderHydrator',
        ),
    ),
    
    'view_helpers' => array(
        'factories'=> array(
            'ShopShowBasket' => 'Shop\View\Helper\ShowBasketFactory',
            'ShopGetOrder'   => 'Shop\View\Helper\GetOrderFactory',
        ),
    ),
    
    'view_manager' => array(
        'template_map' => array(
            'widget/small-basket' => realpath(__DIR__ . '/../view/shop/widget/small-basket.phtml'),
            'widget/full-basket'  => realpath(__DIR__ . '/../view/shop/widget/full-basket.phtml'),
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    
    'navigation' => array(
        'default' => array(
            'bsket' => array(
                'type'       => 'mvc',
                'order'      => '200',
                'label'      => 'Warenkorb',
                'route'      => 'shop/basket',
                'controller' => 'basket',
                'resource'   => 'basket',
                'privilege'  => 'index',
            ),
            'order' => array(
                'type'       => 'mvc',
                'order'      => '300',
                'label'      => 'Bestellungen',
                'route'      => 'shop/order',
                'controller' => 'order',
                'action'     => 'index',
                'resource'   => 'order',
                'privilege'  => 'index',
                'pages'      => array(
                    'update' => array(
                        'type'       => 'mvc',
                        'label'      => 'Bearbeiten',
                        'route'      => 'shop/order',
                        'controller' => 'order',
                        'action'     => 'update',
                    ),
                    'delete' => array(
                        'type'       => 'mvc',
                        'label'      => 'Löschen',
                        'route'      => 'shop/order',
                        'controller' => 'order',
                        'action'     => 'delete',
                    ),
                ),
            ),
        ),
    ),
    
    'acl' => array(
        'guest'   => array(
            'basket' => array('allow' => null),
        ),
        'customer'   => array(
            'order'  => array('allow' => array('create', 'thanks')),
        ),
        'staff'   => array(
            'order' => array('allow' => null),
        ),
    ),
);
