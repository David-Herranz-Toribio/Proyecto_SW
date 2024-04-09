<?php

require_once '../../Config.php';
require_once CLASSES_URL . '/Post.php';
require_once CLASSES_URL . '/Usuario.php';
require_once 'FavoritosHelper.php';

function showProfile($usuario, $favs){

    $user = Usuario::buscaUsuario($usuario);
    $isSelfProfile = $_SESSION['username'] == $user->getUsername();
    $html = "<section class='datos_perfil'>"; 

    // Mostrar nombre de usuario
    if($isSelfProfile)
        $html .= "<h1 class='nombre_perfil'> Mi Perfil </h1>";
    else
        $html .= "<h1 class='nombre_perfil'> Perfil de @" . $user->getUsername() . "</h1>";

    // Mostrar opcion de ajuste si está logeado y es su perfil
    if($isSelfProfile)
        $html .= displaySettingsOption();

    $html .= "</section>";

    // Mostrar imagen de perfil del usuario
    $html .= displayUserImage($user);

    // Mostrar número de seguidores y seguidos del usuario
    $html .= displayFollowersAndFollowed($user);

    // Botón para ver posts favoritos del usuario
    $html .= displayFavoritePosts($user, $favs);

    // Boton de follow/unfollow solo si no estoy en mi perfil
    if(!$isSelfProfile){

        // Obtenemos el objeto Usuario que corresponde al cliente
        $me = Usuario::buscaUsuario($_SESSION['username']); 

        //Comprobamos si seguimos al usuario del perfil a visualizar
        $following = $me->estaSiguiendo($user);
        $textoBoton = $following ? 'Seguir' : 'Dejar de seguir';

        // Boton de follow/unfollow
        $html .= displayFollowButton($user->getUsername(), $textoBoton, $following);
    }

    // Mostrar posts favoritos del usuario
    if($favs){
        // INCLUIR VISTA FavoritosHelper.php
    }

    return $html;
}

function displaySettingsOption(){

    $settingsImage = IMG_PATH . '/Setting_icon__.png';
    $boton_ajuste =<<<EOS
    <div class='datos_perfil'>
        <a href='AjustePerfil.php'>
            <img src='$settingsImage' alt="Modificar Perfil" height="45" width="50">
        </a>
    </div>
    EOS;

    return $boton_ajuste;
}

function displayFollowButton($username, $text, $following){

    $rutaSeguimiento = HELPERS_PATH . '/ProcesarSeguimiento.php'; 
    $rutaRetorno = VIEWS_PATH . '/perfil/Perfil.php';

    $html =<<<EOS
    <div class= "datos_perfil"> 
        <form action=$rutaSeguimiento method="post"> 

        <input type="hidden" name="return" value=$rutaRetorno?user=$username>
        <input type="hidden" name="id" value=$username>
        <input type="hidden" name="no_seguir/seguir" value=$following>
        <button type="submit"> $text </button>

        </form>
    </div>
    EOS;

    return $html;
}

function displayUserImage($image){

    $profile_image_path = IMG_PATH . '/profileImages/' . $image;

    $html =<<<EOS
    <div class='profile_user_image'>
        <img src='$profile_image_path' height='100px' width='100px'>
    </div>
    EOS;

    return $html;
}

function displayFollowersAndFollowed($user){

    $seguidores = displayFollowers($user);
    $seguidos = displayFollowing($user);

    $html =<<<EOS
    <div>
        $seguidores
        $seguidos
    </div>
    EOS;

    return $html;
}

function displayFollowers($user){

    $followers_path = '';
    $num_followers = 1; // Obtener numero de seguidores

    $html =<<<EOS
    <div>
        $num_followers <a href='$followers_path'> seguidores </a>
    </div>
    EOS;

    return $html;
}

function displayFollowing($user){

    $following_path = '';
    $num_following = 1; // Obtener numero de seguidos

    $html =<<<EOS
    <div>
        $num_following <a href='$following_path'> seguidores </a>
    </div>
    EOS;

    return $html;
}

function displayFavoritePosts($user, $favs){
    return mostrarFavoritos($user, $favs);
}