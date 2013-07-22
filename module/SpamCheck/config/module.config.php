<?php
/**
 * ZF2 Buch Kapitel 22
 * 
 * Das Buch "Zend Framework 2 - Das Praxisbuch"
 * von Ralf Eggert ist im Galileo-Computing Verlag erschienen. 
 * ISBN 978-3-8362-2610-3
 * 
 * @package    SpamCheck
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Alle Listings sind urheberrechtlich geschützt!
 * @link       http://www.zendframeworkbuch.de/ und http://www.galileocomputing.de/3460
 */

/**
 * SpamCheck module configuration
 * 
 * @package    SpamCheck
 */
return array(
    'service_manager' => array(
        'factories' => array(
            'SpamCheck\Service\B8' => 'SpamCheck\Service\B8ServiceFactory',
        ),
    ),
    
    'controller_plugins' => array(
        'factories'=> array(
            'SpamCheck' => 'SpamCheck\Controller\Plugin\SpamCheckFactory',
        ),
    ),
    
    'view_helpers' => array(
        'factories'=> array(
            'SpamCheck' => 'SpamCheck\View\Helper\SpamCheckFactory',
        ),
    ),
    
    'b8' => array(
        'config_b8' => array(
            'storage' => 'mysql',
            'rob_x'   => 0.5,
        ),
        'config_database' => array(
            'table_name' => 'b8_wordlist',
        ),
    ),
);
