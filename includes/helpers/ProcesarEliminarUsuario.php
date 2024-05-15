<?php 

require_once '../Config.php';
require_once CLASSES_URL . '/Usuario.php';

$user = null;

if(isset($_SESSION['username']))
    $user = SW\classes\Usuario::buscaUsuario($_SESSION['username']);

if(SW\classes\Usuario::esArtista($user->getUsername())){
    $user->deleteArtist();
}
if($user){
    $user->deleteUser(); 
}
header('Location:'. VIEWS_PATH .'/log/Logout.php');