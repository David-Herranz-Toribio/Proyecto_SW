<?php

use SW\classes\Usuario;

require_once '../../Config.php';
require_once CLASSES_URL . '/Usuario.php'; 

function creacionApartadoUsuario($autor, $origen){

    $rutaPerfil = VIEWS_PATH . '/perfil/Perfil.php';

    //Imagen de usuario junto a su username
    $user = SW\classes\Usuario::buscaUsuario($autor);
    $rutaPFP = IMG_PATH . '/profileImages/'.$user->getPhoto();
    
    $user_info= <<<EOS
    <div class="user_info">
    <div class= 'user_image'> 
    <img alt="user_info" src=$rutaPFP width="50px" height="50px">
    </div>
    <div class= 'user_name'> 
    <a href= "$rutaPerfil?user=$autor" name="user">@$autor</a> 
    </div>
    </div>
    EOS; 
    $me = SW\classes\Usuario::buscaUsuario($_SESSION['username']); 
    $currentUser = $user->getUsername();
    $aux = '';
    if($_SESSION['username'] !== $currentUser) {
        $following = $me->estaSiguiendo($currentUser);
        $textoBoton = $following ? 'Dejar de seguir': 'Seguir' ;
        $aux .= displayFollowButton($currentUser, $textoBoton, $following, $origen);
    }
    $html =<<<EOS7
        <article class = "estiloUsers">
            $user_info
            $aux
        </article>
    EOS7;
    return $html;
}

function displayFollowButton($username, $text, $following, $autor){

    $opcion = $_GET['opcion'] ?? NULL;
    $rutaSeguimiento = HELPERS_PATH . '/ProcesarSeguimiento.php'; 
    $rutaRetorno = VIEWS_PATH . '/perfil/ListaSeguidosSeguidores.php';

    $html =<<<EOS
    <div class= "botones_mensaje"> 
        <form action=$rutaSeguimiento method="post"> 
        <input type="hidden" name="opcion" value="$opcion">
        <input type="hidden" name="return" value="$rutaRetorno?user=$autor&opcion=$opcion">
        <input type="hidden" name="id" value=$username>
        <input type="hidden" name="no_seguir/seguir" value=$following>
        <button class="InfoFoll-button" type="submit"> $text </button>

        </form>
    </div>
    EOS;

    return $html;
}


function showUsers($user, $opcion){
    $content = "<section class = 'listaPost'>";
    if ($opcion == 'FOLLOWERS') {
        $message = "Seguidores de ";
        $lista = $user->obtenerListaSeguidores();
    }
    else {
        $message = "Seguidos de ";
        $lista = $user->obtenerListaSeguidos();
    }
    $message .= $user->getUsername();
    $content = "<h1 class = 'texto_infor'> $message </h1>";
    $result = [];
    foreach ($lista as $nombres) {
        $usuario = Usuario::buscaUsuario($nombres);
        if($usuario) 
            $result[] = $usuario; 
    }
    if(!empty($result)){
        if (isset($_GET['query'])) {
            $textoBusqueda = $_GET['query'];
            $result = $user->LupaUsuariosCoincidentes($result, $textoBusqueda);
        }   
    
        $content .= "<section class = 'listaPost'>";
        foreach($result as $usuario){
            $content .= creacionApartadoUsuario($usuario->getUsername(), $user->getUsername());   
        }
        $content .= "</section>";

    }
    else {
        $content .=<<<EOS
        <div class='lista_seguidores'>
            La lista está vacía
        </div>
        EOS;
    }
    return $content;
}
