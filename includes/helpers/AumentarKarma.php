<?php

use SW\classes\Usuario;

require_once '../Config.php';
require_once CLASSES_URL . '/Usuario.php';

$ruta = isset($_POST['ruta']) ? $_POST['ruta'] : '../../index.php';
$nombre = (isset($_POST['nombre']) & $_POST['nombre'] === "") ?  filter_var($_POST['nombre'], FILTER_SANITIZE_STRING) : false;
if ($nombre != false){
    $user = Usuario::buscaUsuario($nombre);
    $user->aumentaKarma(200);
    $user->actualiza();
}
header('Location: '. $ruta);
exit();
?>