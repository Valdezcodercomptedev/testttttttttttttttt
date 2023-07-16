<?php

if(!defined('DS')){
    define('DS', DIRECTORY_SEPARATOR);
}

if (!defined('ROOT')) {
    define('ROOT', dirname(__DIR__));
}

if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://localhost:80/pha-manager/');
}

if (!defined('APP_DIR')) {
    define('APP_DIR', 'src');
}

if (!defined('APP')) {
    define('APP', ROOT . DS . APP_DIR . DS);
}

if (!defined('CONFIG')) {
    define('CONFIG', ROOT . DS . 'config' . DS);
}

if (!defined('CORE_PATH')) {
    define('CORE_PATH', ROOT . DS . 'Core' . DS);
}

if (!defined('MODEL_PATH')) {
    define('MODEL_PATH', APP . 'Entity' . DS);
}

if (!defined('CONTROLLER_PATH')) {
    define('CONTROLLER_PATH', APP . 'Controller' . DS);
}

if (!defined('VIEW_PATH')) {
    define('VIEW_PATH', BASE_URL . APP_DIR . DS . 'View' . DS);
}

if (!defined('SERVICE_PATH')) {
    define('SERVICE_PATH', APP . 'Service' . DS);
}

if (!defined('TEMPLATE_PATH')) {
    define('TEMPLATE_PATH', BASE_URL . 'template' . DS);
}

if (!defined('ASSETS_PATH')) {
    define('ASSETS_PATH', BASE_URL . 'assets' . DS . 'images' . DS);
}

// Assets files
if (!defined('VIEWS')) {
    define('VIEWS', BASE_URL . APP_DIR . '/View/');
}

if (!defined('ASSETS')) {
    define('ASSETS', BASE_URL . 'assets' . DS);
}

if (!defined('IMAGES')) {
    define('IMAGES', ASSETS . 'images' . DS . 'Company' . DS);
}
if (!defined('IMAGES_TEMP')) {
    define('IMAGES_TEMP', ASSETS . 'images' . DS . 'Template' . DS);
}