<?php
require_once '../../Config.php';
require_once CLASSES_URL . '/TopSearchBar.php';


function displayMessage($message){

    $html =<<<EOS
    <h2 class='texto_infor'> $message </h2>
    EOS;

    return $html;
}

function searchQuery($data, $option){

    $searchBar = SW\classes\TopSearchBar::getInstance();
    $datos = $searchBar->searchQuery($data, $option);
    if(!$datos)
        return false;

    return generateHTML($datos, $option);;
}

function generateHTML($data, $option){
    
    $html = '';
    switch($option){
    case \SW\classes\TopSearchBar::$USUARIOS:
        $html = displayUsers($data);
        break;
    case \SW\classes\TopSearchBar::$SEGUIDORES:
        $html = displayUsers($data);
        break;
    case \SW\classes\TopSearchBar::$PLAYLISTS:
        $html = displayPlaylists($data);
        break;
    case \SW\classes\TopSearchBar::$CANCIONES:
        $html = displayCanciones($data);
        break;
    case \SW\classes\TopSearchBar::$PRODUCTOS:
        $html = displayProductos($data);
        break;
    case \SW\classes\TopSearchBar::$NO_DISPLAY:
    default:
        $html = false;
        break;
    }

    return $html;
}

function displayUsers($data){

    $html = '';
    foreach($data as $user){
        $username = $user['id_user'];
        $nickname = $user['nickname'];
        $photo = $user['foto'];

        $html .=<<<EOS
        <div>  
            <p> $username </p>
            <p> $nickname </p>
            <p> $photo </p>
        </div>
        EOS;
    }

    return $html;
}

function displayPlaylists($data){

    $view_path = VIEWS_PATH . '/musica/PlaylistView.php';
    $html = '<section class="musicList">';
    foreach($data as $playlist){

        // Variables
        $id = $playlist['id_playlist'];
        $image = $playlist['imagen'];
        $nombre = $playlist['nombre'];

        $html .=<<<EOS
        <article class="music_playlist">
            <div class="music_playlist_image">
                <img src="$image" alt="Portada de la playlist">
            </div>

            <div class="music_playlist_info">
                <a href="$view_path?id=$id"><h2> $nombre </h2></a>
            </div>
        </article>
        EOS;
    }
    $html .= '</section>';

    return $html;
}


function displayCanciones($data){

    $playButton = IMG_PATH . '/play_button.png';
    $optionsButton = IMG_PATH . '/options_button.png';

    $html = "<div class='all_albumSongs'>";
    foreach($data as $cancion){

        // Variables
        $titulo = $cancion['titulo'];
        $fecha = $cancion['fecha'];
        $likes = $cancion['likes'];
        $artista = $cancion['id_artista'];
        $photo = $cancion['imagen'];
        $ruta = $cancion['ruta'];

        $html .=<<<EOS
        <div class='album_song'>
            <div class='songName'>
                <p> $titulo </p>
            </div>

            <div class='songDate'>
                <p> $fecha </p>
            </div>

            <div class='songLikes'>
                <p> $likes &#9834 </p>
            </div>

            <div class='songButtons'>
                <button class='playButton' id= 'playSong' ><img src=$playButton></button>
                <span hidden> $ruta </span> 
                <button class='optionsButton'><img src=$optionsButton></button>
            </div>
        </div>
        EOS;
    }
    $html .= "</div>";

    return $html;
}

function displayProductos($data){

    $rutaProducto = VIEWS_PATH . '/tienda/ProductoVista.php';
    $rutaArtista = VIEWS_PATH . '/perfil/Perfil.php';

    $html = '';
    foreach($data as $producto){

        // Variables
        $photo = IMG_PATH .  '/prodImages/'. $producto['imagen'];
        $nombreProducto = $producto['nombre'];
        $nombreArtista = $producto['id_artista'];
        $descripcion = $producto['descripcion'];
        $precio = $producto['precio'];
        $id = $producto['id_prod'];

        // Descricion del producto
        $prodDesc =<<<EOS2
        <div class="prod_info">
            <p>$descripcion</p>
        </div>
        EOS2;

        // Informacion del producto
        $prodInfo =<<<EOS
        <div class="prod_info">
            <a href="$rutaProducto?prod=$id" name= "prod" >
                <img alt="prod_info" src=$photo width="70" heigth="70">
                <p> $nombreProducto </p>
                <p> $precio &#9834 </p>
            </a>
            <div>
                <a href="$rutaArtista?user=$nombreArtista" name="prod" >
                <p> Creador: @$nombreArtista </p>
                </a>
            </div>
        </div>
        EOS;

        $html .=<<<EOS
        <div>
            $prodInfo
            $prodDesc
        </div>
        EOS;
    }

    

    return $html;
}