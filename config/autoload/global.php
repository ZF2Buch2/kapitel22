<?php
/**
 * ZF2 Buch Kapitel 22
 * 
 * Das Buch "Zend Framework 2 - Das Praxisbuch"
 * von Ralf Eggert ist im Galileo-Computing Verlag erschienen. 
 * ISBN 978-3-8362-2610-3
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Alle Listings sind urheberrechtlich geschützt!
 * @link       http://www.zendframeworkbuch.de/ und http://www.galileocomputing.de/3460
 */

/**
 * Global configuration
 * 
 * @package    Application
 */
return array(
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),
    ),
    'db' => array(
        'driver'   => 'Pdo_Sqlite',
        'database' => LUIGI_ROOT . '/data/db/luigi.sqlite3.db',
    ),
    'b8' => array(
        'config_database' => array(
            'database'   => 'luigis-pizza',
            'host'       => 'localhost',
            'user'       => 'luigis-pizza',
            'pass'       => 'luigis-pizza',
        ),
    ),
);
