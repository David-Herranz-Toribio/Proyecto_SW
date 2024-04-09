<?php

require_once '../../Config.php';
require_once CLASSES_URL . '/Post.php';


function showProfile($usuario, $favs){

    $isSelfProfile = $_SESSION['username'] == $usuario;
    $html = "<section class='datos_perfil'>"; 

    // Mostrar nombre de usuario
    if($isSelfProfile)
        $html .= "<h1 class='nombre_perfil'> Mi Perfil </h1>";
    else
        $html .= "<h1 class='nombre_perfil'> Perfil de @" . $usuario . "</h1>";

    // Mostrar opcion de ajuste si está logeado y es su perfil
    if($isSelfProfile)
        $html .= displaySettingsOption();

    $html .= "</section>";


    // Boton de follow/unfollow solo si no estoy en mi perfil
    if(!$isSelfProfile){

        // Obtenemos el objeto Usuario que corresponde al cliente
        $me = Usuario::buscaUsuario($_SESSION['username']); 

        //Comprobamos si seguimos al usuario del perfil a visualizar
        $following = $me->estaSiguiendo($usuario);
        $textoBoton = $following ? 'Seguir' : 'Dejar de seguir';

        // Boton de follow/unfollow
        $html .= displayFollowButton($usuario, $textoBoton, $following);
    }

    
    if($favs){
        $html = "<h1 class='texto_infor'> Posts Favoritos de @".$usuario."</h1>"; 
        $posts = Post::obtenerPostsFavPorUser($usuario); 
    }
    else{
        $posts = Post::obtenerPostsDeUsuario($usuario); 
    }  
    if(!empty($posts)){
        
        $html .= "<section class='listaPost'>";
        if (isset($_GET['query'])) {
            $textoBusqueda = $_GET['query'];
            if($favs){
                $posts = Post::LupaUsuarioPostExistentes($posts, $textoBusqueda);
            }
            else {
                $posts = Post::LupaDescripcionPostExistentes($posts, $textoBusqueda);
            }
        }   
        foreach($posts as $post){
            $html .= creacionPostHTML($post->getAutor(), $post->getImagen(), $post->getLikes(),
                                        $post->getTexto(), $post->getId(), $_SESSION['username']);
            }
        $html .= "</section>";

    }
    else{
        $html .= "<section class = 'listaPost'> <h3> No has dado Like (&#10084) a ningún post</h3></section>";
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

function displayFollowButton($user, $text, $following){

    $rutaSeguimiento = HELPERS_PATH . '/ProcesarSeguimiento.php'; 
    $rutaRetorno = VIEWS_PATH . '/perfil/Perfil.php';

    $html =<<<EOS
    <div class= "datos_perfil"> 
        <form action=$rutaSeguimiento method="post"> 

        <input type="hidden" name="return" value=$rutaRetorno?user=$user>
        <input type="hidden" name="id" value=$user>
        <input type="hidden" name="no_seguir/seguir" value=$following>
        <button type="submit"> $text </button>

        </form>
    </div>
    EOS;

    return $html;
}