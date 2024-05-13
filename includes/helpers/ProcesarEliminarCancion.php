<?php

require_once '../Config.php'; 
require_once CLASSES_URL . '/Cancion.php'; 


$id = filter_var( $_POST['idCancion'], FILTER_VALIDATE_INT ); 

$cancion = SW\classes\Cancion::obtenerCancionPorID($id); 
$cancion->borrarCancion(); 

header('Location: '. VIEWS_PATH . '/perfil/Perfil.php'); 
exit(); 
