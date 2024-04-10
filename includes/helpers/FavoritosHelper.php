<?php

require_once '../../Config.php';
require_once CLASSES_URL . '/Post.php';
require_once CLASSES_URL . '/Usuario.php';

function mostrarFavoritos($user, $favs){

    $html = ''; 
    $posts = Post::obtenerPostsFavPorUser($user->getUsername());

    if(empty($posts)){
        $html .= "<section class='listaPost'><h3> No has dado Like (&#10084) a ningún post</h3></section>";
        return $html;
    }

    $html .= "<section class='listaPost'>";
    if (isset($_GET['query'])) {

        $textoBusqueda = $_GET['query'];
        if($favs)
            $posts = Post::LupaUsuarioPostExistentes($posts, $textoBusqueda);
        else
            $posts = Post::LupaDescripcionPostExistentes($posts, $textoBusqueda);
    }
    
    foreach($posts as $post){
        $html .= creacionPostHTML($post->getAutor(), $post->getImagen(), $post->getLikes(),
                                  $post->getTexto(), $post->getId(), $_SESSION['username']);
    }
    $html .= "</section>";

    return $html;
}
