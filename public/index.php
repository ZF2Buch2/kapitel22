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
 * Application setup
 * 
 * @package    Application
 */

// define request microtime
define('REQUEST_MICROTIME', microtime(true));

// setup autoloading
require_once '../vendor/autoload.php';

// change dir
chdir(dirname(__DIR__));

// define application path
define('LUIGI_ROOT', realpath(__DIR__ . '/..'));

// Run the application!
Zend\Mvc\Application::init(include 'config/application.config.php')->run();
