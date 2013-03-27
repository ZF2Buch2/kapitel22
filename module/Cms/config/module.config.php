<?php
/**
 * ZF2 Buch Kapitel 22
 * 
 * Das Buch "Zend Framework 2 - Von den Grundlagen bis zur fertigen Anwendung"
 * von Ralf Eggert ist im Addison-Wesley Verlag erschienen. 
 * ISBN 978-3-8273-2994-3
 * 
 * @package    Cms
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Alle Listings sind urheberrechtlich geschützt!
 * @link       http://www.zendframeworkbuch.de/ und http://www.awl.de/2994
 */

/**
 * Cms module configuration
 * 
 * @package    Cms
 */
return array(
    'router' => array(
        'routes' => array(
            'cms' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/cms[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'cms',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    
    'controllers' => array(
        'factories' => array(
            'cms' => 'Cms\Controller\CmsControllerFactory',
        ),
    ),
    
    'service_manager' => array(
        'invokables' => array(
            'Cms\Service\Cms' => 'Cms\Service\CmsService',
        ),
    ),
    
    'view_helpers' => array(
        'factories'=> array(
            'CmsContentBlock' => 'Cms\View\Helper\CmsContentBlockFactory',
        ),
    ),
    
    'acl' => array(
        'admin'   => array(
            'cms' => array('allow' => null),
        ),
    ),
);
