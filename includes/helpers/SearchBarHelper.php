<?php
require_once '../../Config.php';
require_once CLASSES_URL . '/TopSearchBar.php';
require 'PostHelper.php';
require 'PerfilHelper.php';
require_once 'TiendaHelper.php';

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
    
    $html =<<<EOS
    <h2 class='texto_infor'> $option </h2>
    EOS;
    switch($option){
    case \SW\classes\TopSearchBar::$USUARIOS:
        $html .= display_users($data);
        break;
    case \SW\classes\TopSearchBar::$SEGUIDORES:
        $html .= display_users($data);
        break;
    case \SW\classes\TopSearchBar::$POSTS:
        $html .= display_posts($data);
        break;
    case \SW\classes\TopSearchBar::$PLAYLISTS:
        $html .= display_playlists($data);
        break;
    case \SW\classes\TopSearchBar::$CANCIONES:
        $html .= display_canciones($data);
        break;
    case \SW\classes\TopSearchBar::$PRODUCTOS:
        $html .= display_productos($data);
        break;
    case \SW\classes\TopSearchBar::$NO_DISPLAY:
    default:
        $html = false;
        break;
    }

    return $html;
}

function display_users($data){

    $rutaPerfil = VIEWS_PATH . '/perfil/Perfil.php';

    $html =<<<EOS
    <section class='listaUsuarios'>
    EOS;
    foreach($data as $user){
        $username = $user['id_user'];
        $photo = IMG_PATH . '/profileImages/' . $user['foto'];

        $html .=<<<EOS
        <article class='estiloUsers'>
            <div class= 'user_image'> 
                <img alt="user_info" src=$photo width="50px" height="50px">
            </div>
            <div class='user_name'> 
                <a href="$rutaPerfil?user=$username" name="user"> @$username </a> 
            </div>
        </article>
        EOS;
    }
    $html .=<<<EOS
    </section>
    EOS;

    return $html;
}

function display_posts($data){

    $html =<<<EOS
    <section class='listaPost'>
    EOS;
    foreach($data as $post){
        $html .= creacionPostHTML($post['id_user'], $post['imagen'], $post['likes'], 
        $post['texto'], $post['id_post'], $post['origen'], $_SESSION['username']);
    }
    $html .= '</section>';
    
    return $html;
}

function display_playlists($data){

    $view_path = VIEWS_PATH . '/musica/PlaylistView.php';
    $html = '<section class="musicList">';
    foreach($data as $playlist){

        // Variables
        $id = $playlist['id_playlist'];
        $image = $playlist['imagen'];
        $nombre = $playlist['nombre'];
        $image = IMG_PATH . '/songImages/' . $playlist['imagen'];

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

function display_canciones($data){

    $playButton = IMG_PATH . '/play_button.png';
    $optionsButton = IMG_PATH . '/options_button.png';

    $html = "<div class='allSongs'>";
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

function display_productos($data){

    $rutaProducto = VIEWS_PATH . '/tienda/ProductoVista.php';
    $rutaArtista = VIEWS_PATH . '/perfil/Perfil.php';
    $rutaCompra = HELPERS_PATH . '/ProcesarProducto.php';

    $username = $_SESSION['username'];
    $html = '';
    foreach($data as $producto){

        $rutaProdImg = IMG_PATH . '/prodImages/' . $producto['imagen'];
        $id = $producto['id_prod'];
        $nombre = $producto['nombre'];
        $autor = $producto['id_artista'];
        $stock = $producto['stock'];
        $descripcion = $producto['descripcion'];
        $precio = $producto['precio'];

        //Imagen y nombre del producto
        $prodInfo =<<<EOS
        <div class="prod_info">
            <a href= "$rutaProducto?prod=$id" name= "prod" >
                <img alt = "prod_info" src= $rutaProdImg width = "70" heigth = "70">
                <p>$nombre</p>
            </a>
            <div>
                <a href= "$rutaArtista?user=$autor" name= "prod" >
                <p>Creador: @$autor</p>
                </a>
            </div>
        </div>
        EOS;

        $compra = '<p> No queda stock </p>';
        if($stock != 0){
            $compra =<<<EOS
            <button type = "submit" class = "botonCompra"> Comprar </button>
            <input type="number" name="Cantidad" value="0" min="0" max=$stock/>
            <p style="display:inline"> <output name="result">0</output> &#9834</p>
            EOS;
        }

        // Descripcion del producto
        $prodDesc =<<<EOS2
        <div class="prod_info">
            <p>$descripcion</p> 
            <p>Quedan $stock unidades por valor de $precio &#9834 cada una</p>
        EOS2;

        // No mostrar botones de compra si es mi misma pagina 
        if($username !== $autor){
            $prodDesc .= <<<EOS2
            <form action = $rutaCompra method="post" oninput="result.value= (parseFloat($precio) * parseInt(Cantidad.value)).toFixed(2)">            
                <input hidden name="Id" value= $id> 
                $compra
            </form>
            EOS2;
        }
        $prodDesc .= "</div>";  
        
        // Eliminar y modificar un producto
        $botones = '';
        if ($username == $autor || (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == true)){
            $rutaMod = VIEWS_PATH . '/tienda/MiTiendaVista.php';
            $rutaEliminar = HELPERS_PATH . '/ProcesarElimProd.php';

            $botones .= <<<EOS4
            <div class= 'modElim'> 
            <form action = $rutaMod method="get">
                <input type = "hidden" name = "ModificarID" value = "$id">
                <button type = "submit"> &#9998 </button>
            </form>

            <form action= $rutaEliminar method="post">
                <input type="hidden" name="EliminarID" value= '$id'>
                <button type="submit"> &#10060 </button>
            </form>
            </div>
            EOS4;
        }
        
        $html =<<<EOS6
        <section class='listaArticulos'>
        <article class="estiloProd">
            $prodInfo
            $prodDesc
            $botones
        </article>
        </section>
        EOS6;
    }


    return $html;
}