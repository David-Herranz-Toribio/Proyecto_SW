<?php
require_once '../Config.php';
require_once CLASSES_URL . '/Suscripcion.php';

$ruta =isset($_POST['actualizar']) ? $_POST['actualizar'] : '../../index.php';
if (isset($_SESSION['isAdmin'])) {
    SW\classes\Suscripcion::actualizarSuscripcion(date('Y-m-d H:i:s')); 
}else{
    
}
header('Location: '. $ruta);
exit();
?>