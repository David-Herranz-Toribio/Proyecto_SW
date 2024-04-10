<?php
require_once "../Config.php";
require_once CLASSES_URL . '/Usuario.php';


$usu_a_seguir = $_POST["id"]; 
$accion_a_tomar = boolval($_POST['no_seguir/seguir']); 
$retorno = $_POST["return"]; 


$usuario_seguidor = Usuario::buscaUsuario($_SESSION['username']); 
$username = $usuario_seguidor->getUsername(); 

if($accion_a_tomar){ //Dejar de seguir 
    $usuario_seguidor->dejarDeSeguir($usu_a_seguir); 
}

else $usuario_seguidor->seguir($usu_a_seguir); //Seguir


header('Location: ' . $retorno);
exit();