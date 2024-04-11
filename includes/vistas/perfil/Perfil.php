<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/PerfilHelper.php';

$usuario = '';
$favs = '';
$content = '';
$opcion= $_POST['opcion'] ?? NULL; 


// Obtenemos el username del perfil a visualizar (Otro usuario/Yo)
if(isset($_SESSION['username'])){
    $usuario = $_GET["user"] ?? $_SESSION['username'];
    $user = Usuario::buscaUsuario($usuario);
    $favs = $_GET["favs"] ?? NULL;
    $content = showProfile($user, $favs);
     
     switch($opcion) {
        case NULL: 
        
        case 'publicados': 
            $content .= displayPosts($user);
            break; 
        
        case 'favoritos': 
            $content .= displayFavoritePost($user); 
            break; 

        case 'pedidos': 
            //mostrar historial de pedidos 
            break; 

        case 'productos': 
            //mostrar tienda de usuario 
            break; 
    } 
}
else{
    $content = showNotLogged();
}

require_once LAYOUT_URL;
