<?php 

require_once 'classes/Aplicacion.php';

// Rutas de archivos
define('PROJECT_PATH', '/Proyecto_SW');
define('CSS_PATH' , PROJECT_PATH . '/css');
define('IMG_PATH' , PROJECT_PATH . '/img');
define('INCLUDES_PATH', PROJECT_PATH . '/includes');
    define('CLASSES_PATH', INCLUDES_PATH . '/classes');
    define('HELPERS_PATH', INCLUDES_PATH . '/helpers');
    define('VIEWS_PATH', INCLUDES_PATH . '/vistas');
        define('LAYOUT_PATH' , VIEWS_PATH . '/layout/Layout.php');
define('JS_PATH', PROJECT_PATH . '/js');
define('BD_PATH', PROJECT_PATH . '/mysql');

// URLs
define('ROOT_PATH', dirname(__DIR__) . '/../Proyecto_SW');
define('CSS_URL' , ROOT_PATH . '/css');
define('IMG_URL' , ROOT_PATH . '/img');
define('INCLUDES_URL', ROOT_PATH . '/includes');
    define('CLASSES_URL', INCLUDES_URL . '/classes');
    define('HELPERS_URL', INCLUDES_URL . '/helpers');
    define('VIEWS_URL', INCLUDES_URL . '/vistas');
        define('LAYOUT_URL' , VIEWS_URL . '/layout/Layout.php');
define('JS_URL', ROOT_PATH . '/js'); 
define('BD_URL', ROOT_PATH . '/mysql');

//  Parámetros BD
define('BD_HOST', 'localhost');
define('BD_NAME', '2melody');

// Cuenta a crear en el phpmyadmin --> Desde phpmyadmin, pulsar pestaña Cuentas de usuario, pulsar Agregar nuevo Usuario,
// y añadir el nombre y la contraseña de aqui abajo. Al añadir, seleccionar privilegios globales. 
define('BD_USER', 'user');
define('BD_PASS', 'pass');

// UTF-8
ini_set('default_charset', 'UTF-8');
setLocale(LC_ALL, 'es_ES.UTF.8');

// Zona horaria
date_default_timezone_set('Europe/Madrid');

// Autoload
spl_autoload_register(function ($class) {
    
    // project-specific namespace prefix
    $prefix = 'SW\\classes';
    
    // base directory for the namespace prefix
    $base_dir = __DIR__ . '/';
    
    // does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // no, move to the next registered autoloader
        return;
    }
    
    // get the relative class name
    $relative_class = substr($class, $len);
    
    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});

// Crear una sesion
session_start();

// Inicialización de la base de datos
$app = SW\classes\Aplicacion::getInstance();
$app->init(['host'=> BD_HOST, 'user'=> BD_USER, 'pass'=> BD_PASS, 'database'=> BD_NAME]);