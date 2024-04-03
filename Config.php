<?php 

//  Rutas de archivos
define('RAIZ_APP', dirname(__DIR__));

define('RUTA_PROYECTO_PATH', '/Proyecto_SW');
define('RUTA_IMG_PATH' , RUTA_PROYECTO_PATH.'/img');
define('RUTA_VISTAS_PATH' , RUTA_PROYECTO_PATH.'/vistas');
define('RUTA_HELPERS_PATH' , RUTA_PROYECTO_PATH.'/helpers');
define('RUTA_CSS_PATH' , RUTA_PROYECTO_PATH.'/css');

define('RUTA_PROYECTO', RAIZ_APP.'/Proyecto_SW');
define('RUTA_BD', RUTA_PROYECTO.'/BD');
define('RUTA_CLASSES', RUTA_PROYECTO.'/classes');
define('RUTA_CSS' , RUTA_PROYECTO.'/css');
define('RUTA_IMG' , RUTA_PROYECTO.'/img');
define('RUTA_HELPERS', RUTA_PROYECTO.'/helpers');
define('RUTA_VISTAS', RUTA_PROYECTO.'/vistas');
define('RUTA_LAYOUTS' , RUTA_VISTAS.'/layout/Layout.php');


//  Parámetros BD
define('BD_HOST', 'localhost');
define('BD_NAME', '2melody');

// Cuenta a crear en el phpmyadmin --> Desde phpmyadmin, pulsar pestaña Cuentas de usuario, pulsar Agregar nuevo Usuario,
// y añadir el nombre y la contraseña de aqui abajo. Al añadir, seleccionar privilegios globales. 
define('BD_USER', 'user');
define('BD_PASS', 'pass');

session_start();