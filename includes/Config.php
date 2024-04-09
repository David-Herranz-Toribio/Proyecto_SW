<?php 

//  Rutas de archivos
define('PROJECT_PATH', '/Proyecto_SW');
define('CSS_PATH' , PROJECT_PATH . '/css');
define('IMG_PATH' , PROJECT_PATH . '/img');
define('INCLUDES_PATH', PROJECT_PATH . '/includes');
    define('CLASSES_PATH', INCLUDES_PATH . '/classes');
    define('HELPERS_PATH', INCLUDES_PATH . '/helpers');
    define('VIEWS_PATH', INCLUDES_PATH . '/vistas');
        define('LAYOUT_PATH' , VIEWS_PATH . '/layout/Layout.php');
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
define('BD_URL', ROOT_PATH . '/mysql');

//  Parámetros BD
define('BD_HOST', 'localhost');
define('BD_NAME', '2melody');

// Cuenta a crear en el phpmyadmin --> Desde phpmyadmin, pulsar pestaña Cuentas de usuario, pulsar Agregar nuevo Usuario,
// y añadir el nombre y la contraseña de aqui abajo. Al añadir, seleccionar privilegios globales. 
define('BD_USER', 'user');
define('BD_PASS', 'pass');

session_start();