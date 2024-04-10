<?php

require_once '../../Config.php';
require_once CLASSES_URL . '/Post.php';
require_once CLASSES_URL . '/Usuario.php';
require_once 'PostHelper.php';


function showNotLogged(){

    $html =<<<EOS
    <h1 class='texto_infor'> No estas logead@ </h1>
    EOS;

    return $html;
}

function showProfile($usuario, $favs){

    $user = Usuario::buscaUsuario($usuario);
    if(!$user){
        $html =<<<EOS
        <div class='notFoundError'>
            ¡No se han encontrado resultados!
        </div>
        EOS;

        return $html;
    }

    $isArtist = $_SESSION['isArtist'];
    $isSelfProfile = $_SESSION['username'] == $usuario;

    // Mostrar el header del perfil -> imagen, fecha de nacimiento, nickname, username, boton de follow, descripcion + [opciones]
    $html = displayProfileHeader($user, $isArtist, $favs, $isSelfProfile);

    // Mostrar los posts publicados por el usuario
    $html .= displayPosts($user);

    return $html;
}

function displayProfileHeader($user, $isArtist, $favs, $isSelfProfile){
    
    $html = "<section class='datos_perfil'>";

    // Mostrar imagen, nickname, username y descripcion
    $html .= displayUserImage($user->getPhoto());
    $html .= displayNickname($user->getNickname());
    $html .= displayUsername($user->getUsername());
    $html .= displayUserDescription($user->getDescrip());

    // Mostrar opcion de ajuste si está logeado y es su perfil
    if($isSelfProfile)
        $html .= displaySettingsOption();
  
    // Mostrar link de tienda si es un artista
    if($isArtist)
        $html .= displayShopLink($user);

    // Mostrar followers/following
    $html .= displayFollowersAndFollowed($user);

    // Mostrar botón de favoritos solo si es tu perfil
    if($isSelfProfile)
        $html .= displayFavoritePostsButton($user, $favs);

    // Mostrar botón de follow/unfollow si es el perfil de otro usuario
    if(!$isSelfProfile){

        // Obtenemos el objeto Usuario que corresponde al cliente
        $me = Usuario::buscaUsuario($_SESSION['username']); 

        //Comprobamos si seguimos al usuario del perfil a visualizar
        $following = $me->estaSiguiendo($user->getUsername());
        $textoBoton = $following ? 'Seguir' : 'Dejar de seguir';

        // Boton de follow/unfollow
        $html .= displayFollowButton($user->getUsername(), $textoBoton, $following);
    }

    $html .= "</section>";

    return $html;
}

function displayPosts($user){

    $lista_posts = Post::obtenerPostsDeUsuario($user->getUsername());
    $html = "<section class='posts_perfil'>";

    if(!$lista_posts){
        $html =<<<EOS
        No se ha publicado nada aun ¡Crea una publicación ahora!
        EOS;

        return $html;
    }

    foreach($lista_posts as $post){
        $html .= creacionPostHTML($post->getAutor(), $post->getImagen(), $post->getLikes(), 
                                  $post->getTexto(), $post->getId(), $user->getUsername());
    }

    $html .= "</section>";

    return $html;
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
    <div class='user_image'>
        <img src='$profile_image_path' height='100px' width='100px'>
    </div>
    EOS;

    return $html;
}

function displayNickname($nickname){
    
    $html =<<<EOS
    <div clas='user_nickname'>
        <p> $nickname </p>
    </div>
    EOS;

    return $html;
}

function displayUsername($username){

    $html =<<<EOS
    <div clas='user_username'>
        <p> @$username </p>
    </div>
    EOS;

    return $html;
}

function displayUserDescription($desc){

    $html =<<<EOS
    <div class='user_desc'>
        <p> $desc </p>
    </div>
    EOS;

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

function displayShopLink($artist){

    $shop_name = 'Tienda: ' . $artist->getUsername();
    $shop_link = VIEWS_PATH . '/tienda/MiTiendaVista.php';

    $html =<<<EOS
    <div class='shop_link'>
        <a href='$shop_link'> $shop_name </a>
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

function displayFavoritePostsButton($user, $favs){

    $username = $user->getUsername();
    $favs_view = VIEWS_PATH . '/perfil/Favoritos.php';

    $html =<<<EOS
    <form action='$favs_view' method='post'>
        <input type='hidden' name='user' value='$username'>
        <input type='hidden' name='favs' value='$favs'>
        <button type='submit'> Favs </button>
    </form>
    EOS;

    return $html;
}