<?php
require_once '../../Config.php';
require_once CLASSES_URL . '/TopSearchBar.php';



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

    $html = '';
    foreach($data as $playlist){
        $nombrePlaylist = $playlist['nombre'];
        $fecha = $playlist['fecha'];
        $photo = $playlist['imagen'];

        $html .=<<<EOS
        <div>  
            <p> $nombrePlaylist </p>
            <p> $fecha </p>
            <p> $photo </p>
        </div>
        EOS;
    }

    return $html;
}

function displayCanciones($data){

    $html = '';
    foreach($data as $cancion){
        $titulo = $cancion['titulo'];
        $artista = $cancion['id_artista'];
        $photo = $cancion['imagen'];

        $html .=<<<EOS
        <div>  
            <p> $titulo </p>
            <p> $artista </p>
            <p> $photo </p>
        </div>
        EOS;
    }

    return $html;
}

function displayProductos($data){

    $html = '';
    foreach($data as $producto){
        $photo = $producto['imagen'];
        $nombreProducto = $producto['nombre'];
        $nombreArtista = $producto['id_artista'];
        $descripcion = $producto['descripcion'];
        $precio = $producto['precio'];

        $html .=<<<EOS
        <div>  
            <p> $photo </p>
            <p> $nombreProducto </p>
            <p> $nombreArtista </p>
            <p> $descripcion </p>
            <p> $precio </p>
        </div>
        EOS;
    }

    return $html;
}