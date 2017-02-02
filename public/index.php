<?php
/**
 * Index file from the application
 * Loads all required files and start new application
 */

// Define URL and folders
define('BASE_URL', '//' . $_SERVER['HTTP_HOST'] . DIRECTORY_SEPARATOR);
define('URL', BASE_URL . 'index.php?url=');
define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
define('APPLICATION', ROOT . 'application' . DIRECTORY_SEPARATOR);

// Load config file
require ROOT . 'config.php';

// Load model & core files
foreach (glob(APPLICATION . 'model/*.php') as $fileName) {
    require $fileName;
}
foreach (glob(APPLICATION . 'core/*.php') as $fileName) {
    require $fileName;
}

// Start the application
$app = new Application();
