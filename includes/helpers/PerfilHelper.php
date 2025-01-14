<?php

require_once '../../Config.php';
require_once CLASSES_URL . '/Post.php';
require_once CLASSES_URL . '/Usuario.php';
require_once CLASSES_URL . '/Playlist.php';
require_once CLASSES_URL . '/Cancion.php';
require_once CLASSES_URL . '/FormularioCrearAlbum.php';
require_once 'PostHelper.php';
require_once 'TiendaHelper.php';
require_once 'MusicaHelper.php';


// Constantes para navegar entre vistas
define('POSTS_VIEW', 'POSTS');
define('FAVS_VIEW', 'FAVS');
define('PRODUCTS_VIEW', 'PRODUCTS');
define('ORDERS_VIEW', 'ORDERS');
define('MUSIC_VIEW', 'MUSIC');


function showNotLogged(){
    
    $html = "<section class='default'>";
    $html .=<<<EOS
    <h1 class='texto_infor'> No estas loguead@ para ver el perfil </h1>
    EOS;

    return $html;
}

function showProfile($user, $opcion){

    $isSelfProfile = $_SESSION['username'] == $user->getUsername();
    $isArtist = SW\classes\Usuario::esArtista($user->getUsername());

    // Mostrar el header del perfil -> imagen, fecha de nacimiento, nickname, username, boton de follow, descripcion + [opciones]
    $html = displayProfileHeader($user, $isArtist, $isSelfProfile);

    // Mostrar contenido
    $html .= displayContent($user, $opcion);

    return $html;
}

function displayProfileHeader($user, $isArtist, $isSelfProfile){
    
    $html = "<section class='datos_perfil'>";
    $html .= "<div class= 'identidad'>";

    // Mostrar imagen
    $html .= displayUserImage($user);

    // Mostrar nickname y username
    $html .= "<div class='user_info'>";
    $html .= displayNickname($user);
    $html .= displayUsername($user);
    $html .= "</div>";

    // Mostrar las corcheas si es el perfil del cliente
    if($isSelfProfile)
        $html .= displayCredit($user);

    // Mostrar opcion de ajuste si está logeado y es su perfil
    if($isSelfProfile)
        $html .= displaySettingsOption();
    
    // Mostrar botón de follow/unfollow si es el perfil de otro usuario
    if(!$isSelfProfile){

        // Obtenemos el objeto Usuario que corresponde al cliente
        $me = SW\classes\Usuario::buscaUsuario($_SESSION['username']); 

        //Comprobamos si seguimos al usuario del perfil a visualizar
        $following = $me->estaSiguiendo($user->getUsername());
        $textoBoton = $following ? 'Dejar de seguir': 'Seguir' ;

        // Boton de follow/unfollow
        $html .= displayFollowButton($user, $textoBoton, $following);
    }
    $html .= "</div>"; 

    // Mostrar fecha de nacimiento del usuario
    $html .= displayBirthday($user);

    // Mostrar descripción del usuario
    $html .= displayUserDescription($user);

    // Mostrar followers/following
    $html .= displayFollowersAndFollowed($user); 

    /* SECCION DE BOTONES */
    $html .= "<div class='menu_perfil'>";

    // Mostrar boton de posts
    $html .= displayPostsButton($user);

    //Mostrar boton de favoritos
    $html .= displayFavoritePostsButton($user);

    if($isArtist)
        $html .= displayMusicButton($user);

    // Mostrar boton de pedidos si es el perfil del cliente
    if($isSelfProfile)
        $html .= displayOrdersButton($user);

    // Mostrar boton de tienda si es un artista
    if($isArtist)
        $html .= displayShopButton($user);

    $html.= "</div> "; 
    $html .= "</section>";

    return $html;
}

function displayContent($user, $opcion){

    $html = '';
    switch($opcion) {

        case NULL:
        case 'POSTS':
            $html = displayPosts($user);
            break; 
        
        case 'FAVS':
            $html = displayFavoritePost($user); 
            break; 

        case 'ORDERS':
            $html = displayOrders($user);
            break; 

        case 'PRODUCTS':
            $html = displayProducts($user);
            break;

        case 'MUSIC':
            $html = displayMusic($user);
            break;

        default:
            $html = 'VISTA NO RECONOCIDA';
            break;
    }

    return $html;
}

function displayPosts($user){

    $lista_posts = SW\classes\Post::obtenerPostsDeUsuario($user->getUsername());
    $html = "<section class='publicaciones_perfil'>";

    if(!$lista_posts){
        $html .=<<<EOS
        No se ha publicado nada aun ¡Crea una publicación ahora!
        EOS;

        return $html;
    }
    foreach($lista_posts as $post){
        $html .= creacionPostHTML($post->getAutor(), $post->getImagen(), $post->getLikes(), 
                                  $post->getTexto(), $post->getId(), $post->getPadre(), $_SESSION['username']);
    }

    $html .= "</section>";

    return $html;
}

function displayFavoritePost ($user){

    $html = ''; 
    $posts = SW\classes\Post::obtenerPostsFavPorUser($user->getUsername());
    $html .= "<section class='publicaciones_perfil'>";
    if(empty($posts)){
        $html .= "<section class='publicaciones_perfil'><h3> No has dado Like (&#10084) a ningún post</h3></section>";
        return $html;
    }
    else if (isset($_GET['query'])) {
        $textoBusqueda = $_GET['query'];
    }
    
    foreach($posts as $post){
        $html .= creacionPostHTML($post->getAutor(), $post->getImagen(), $post->getLikes(),
                                  $post->getTexto(), $post->getId(), $post->getPadre(), $_SESSION['username']);
    }
    $html .= "</section>";

    return $html;
}

function displayOrders($user){

    $lista_pedidos = showHistorialPedidos($user->getUsername());

    $html =<<<EOS
    <section class='publicaciones_perfil'> 
        $lista_pedidos
    </section> 
    EOS;

    return $html;
}

function displayProducts($user){

    $productos = showProductsArtista($user->getUsername()); 
    $html =<<<EOS
        $productos
    EOS; 

    return $html;
}

function displayMusic($user){

    $username = $user->getUsername();
    $html = '';

    // Si el artista visita su pagina -> mostramos las playlist
    if(isset($_SESSION['username']) && $username === $_SESSION['username']){
        $html = showPlaylists($username);
    }

    // Si el cliente visita la pagina de un artista -> mostramos como albumes
    else{
        $html = displayArtistMusic($username);
    }

    return $html;
}

function displayFollowButton($user, $text, $following){

    $username = $user->getUsername();

    $rutaSeguimiento = HELPERS_PATH . '/ProcesarSeguimiento.php'; 
    $rutaRetorno = VIEWS_PATH . '/perfil/Perfil.php';

    $html =<<<EOS
    <div class= "boton_seguir"> 
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

function displayUserImage($user){

    $image = $user->getPhoto();
    $profile_image_path = IMG_PATH . '/profileImages/' . $image;

    $html =<<<EOS
    <div class='user_image'>
        <img src='$profile_image_path' height='100px' width='100px'>
    </div>
    EOS;

    return $html;
}

function displayNickname($user){
    
    $nickname = $user->getNickname();

    $html =<<<EOS
    <div class='user_nickname'>
        <p> $nickname </p>
    </div>
    EOS;

    return $html;
}

function displayUsername($user){

    $username = $user->getUsername();

    $html =<<<EOS
    <div class='user_username'>
        <p> @$username </p>
    </div>
    EOS;

    return $html;
}

function displayCredit($user){

    $credit = $user->getKarma();

    $html =<<<EOS
    <div>
        <p> $credit &#9834 </p>
    </div>
    EOS;

    return $html;
}

function displayBirthday($user){

    $birthday = $user->getBirthdate();

    $html =<<<EOS
    <div class='user_birthday'>
        <p> Nacimiento: $birthday </p>
    </div>
    EOS;

    return $html;
}

function displayUserDescription($user){

    $desc = $user->getDescrip();

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

function displayFollowersAndFollowed($user){

    $seguidores = displayFollowers($user);
    $seguidos = displayFollowing($user);

    $html =<<<EOS
    <div>
        <div> 
        $seguidores
        </div>

        <div>
        $seguidos
        </div>
    </div>
    EOS;

    return $html;
}

function displayFollowers($user){

    $lista_seguidores = $user->obtenerListaSeguidores();
    $username = $user->getUsername();
    $num_followers = count($lista_seguidores); 
    $url = VIEWS_PATH . '/perfil/ListaSeguidosSeguidores.php';
    $opcion = 'FOLLOWERS';
    $html =<<<EOS
    <form action="$url" method="GET">
        <input type="hidden" name="opcion" value="$opcion">
        <input type="hidden" name="user" value="$username">
        <p> $num_followers <button class="InfoFoll-button" type="submit">Seguidores</button> </p>
    </form>
    EOS;
    return $html;
}

function displayFollowing($user){

    $lista_seguidos = $user->obtenerListaSeguidos();
    $num_following = count($lista_seguidos); 
    $username = $user->getUsername();
    $url = VIEWS_PATH . '/perfil/ListaSeguidosSeguidores.php';
    $opcion = 'FOLLOWED';
    $html =<<<EOS
    <form action="$url" method="GET">
        <input type="hidden" name="opcion" value="$opcion">
        <input type="hidden" name="user" value="$username">
        <p> $num_following <button class="InfoFoll-button" type="submit">Siguiendo</button> </p>
    </form>
    EOS;
    return $html;
}

function displayArtistMusic($artist_username){

    $albums = \SW\classes\Playlist::obtenerPlaylistsBD($artist_username);
    if(!$albums){

        $html =<<<EOS
        <section class="emptyMusicList">
            <p> Este artista no tiene música aún... </p>
        </section>
        EOS;

        return $html;
    }

    // Mostrar todas las playlists
    $html = "<section class='artist_music'>";
    foreach($albums as $p){

        // No mostrar la playlist de favoritos -> privada
        if($p->getPlaylistNombre() == SW\classes\Playlist::$DEFAULT_PLAYLIST)
            continue;

        $html .= "<div class='fullAlbum'>";
        $html .= displayArtistAlbum($p);
        $html .= displayAlbumMusic($p);
        $html .= "</div>";
    }
    $html .= "</section>";

    return $html;
}

function displayArtistAlbum($playlist){

    $playButton = IMG_PATH . '/play_button.png';
    $icono_flecha = IMG_PATH . '/flecha_desp.png';
    $portadaPlaylist= IMG_PATH .'/songImages/' . $playlist->getPlaylistImagen(); 

    $html =<<<EOS
    <div class='album_header'>
        <div class='album_image'>
            <img src="{$portadaPlaylist}" alt="Portada del album">
        </div>

        <div class='album_info'>
            <h2> {$playlist->getPlaylistNombre()} </h2>
            <button class='desplegable_canciones'><img class='icono_flecha' src=$icono_flecha></button>
            <button class='playButton' id='startPlaylist'> <img src=$playButton></button>
            <span hidden> {$playlist->getIdPlaylist()} </span> 
        </div>

    </div>
    EOS;

    return $html;
}

function displayAlbumMusic($playlist){
  
    $canciones = \SW\classes\Cancion::getSongsFromPlaylistID($playlist->getIdPlaylist());
    if(!$canciones){

        $html =<<<EOS
        <div class='all_albumSongs'>
            <h3> Vacío </h3>
        </div>
        EOS;

        return $html;
    }

    $html = "<div class='all_albumSongs'>";
    foreach($canciones as $cancion){
       $html.= displayMusicStyle($cancion); 
    }
    $html .= "</div>";

    return $html;
}

function displayPostsButton($user){

    $username = $user->getUsername();
    $value = POSTS_VIEW;
    $view_path = VIEWS_PATH . '/perfil/Perfil.php';

    $html =<<<EOS
    <div class='opcion_posts'>
    <form action=$view_path method='get'>
        <input type= 'hidden' name= 'user' value= '$username'>
        <input type='hidden' name='opcion' value='$value'>
        <button type='submit'> Posts </button>
    </form>
    </div>
    EOS;

    return $html;
}

function displayFavoritePostsButton($user){

    // Sin usar ahora pero util para mostrar favoritos de otros usuarios en el futuro
    $username = $user->getUsername();
    $value = FAVS_VIEW;
    $view_path = VIEWS_PATH . '/perfil/Perfil.php';

    $html =<<<EOS
    <div class='opcion_favoritos'>
    <form action=$view_path method='get'>
        <input type= 'hidden' name= 'user' value= '$username'>
        <input type='hidden' name='opcion' value='$value'>
        <button type='submit'> Favs </button>
    </form>
    </div>
    EOS;

    return $html;
}

function displayMusicButton($user){

    $username = $user->getUsername();
    $value = MUSIC_VIEW;
    $view_path = VIEWS_PATH . '/perfil/Perfil.php';

    $html =<<<EOS
    <div class='opcion_musica'>
    <form action=$view_path method='get'>
        <input type= 'hidden' name= 'user' value= '$username'>
        <input type='hidden' name='opcion' value='$value'>
        <button type='submit'> Musica </button>
    </form>
    </div>
    EOS;

    return $html;
}

function displayShopButton($user){

    $username = $user->getUsername();
    $value = PRODUCTS_VIEW;
    $view_path = VIEWS_PATH . '/perfil/Perfil.php';

    $html =<<<EOS
    <div class='opcion_tienda'>
    <form action= $view_path method='get'>
        <input type= 'hidden' name= 'user' value= '$username'>
        <input type='hidden' name='opcion' value='$value'>
        <button type='submit'> Tienda </button>
    </form>
    </div>
    EOS;

    return $html;
}

function displayOrdersButton($user){

    $username = $user->getUsername();
    $value = ORDERS_VIEW;
    $view_path = VIEWS_PATH . '/perfil/Perfil.php';

    $html =<<<EOS
    <div class='opcion_pedidos'>
    <form action= $view_path method='get'>
        <input type= 'hidden' name= 'user' value= '$username'>
        <input type='hidden' name='opcion' value='$value'>
        <button type='submit'> Pedidos </button>
    </form>
    </div>
    EOS;

    return $html;
}