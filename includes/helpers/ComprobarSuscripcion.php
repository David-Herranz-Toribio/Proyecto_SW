<?php
require_once '../Config.php';
require_once CLASSES_URL . '/Producto.php';

if (isset($_SESSION['username'])) {
    if (isset($_SESSION['isSub'])) {
        $fechaExpiracion =  SW\classes\Producto::getFechaExpiracion($_SESSION['username']);
        $fechaActual = new \DateTime();
        if ($fechaActual->format('Y-m-d H:i:s') > $fechaExpiracion) {
            $done = SW\classes\Producto::eliminarSuscripcion($_SESSION['username']);
            $_SESSION['isSub'] = null;
            echo "OK";
        }
    }
}
?>