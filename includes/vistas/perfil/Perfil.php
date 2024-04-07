<?php

require_once '../../../Config.php';
require_once CLASSES_PATH . '/Post.php';

$usuario = $_GET["user"] ?? NULL;
$favs = $_GET["favs"] ?? NULL;
$content = showProfile($usuario,$favs);

//require_once LAYOUT_PATH;

function showProfile($usuario,$favs){
    $SettingsImage = IMG_PATH . '/Setting_icon__.png';
    $boton_ajuste= ''; 
    if(!$usuario){
        if (isset($_SESSION['username'])){ //Hay sesion iniciada
            $boton_ajuste= <<<EOS
            <p>
            <section class="datos_perfil">
            <a href="AjustePerfil.php">
                <img src='$SettingsImage' alt="Modificar Perfil" height="45" width="50">
            </a>
            </section>
            </p>
            EOS;
            $usuario = $_SESSION['username'];
        }
    }

    if($usuario) {

        $html= "<section class = 'datos_perfil'>"; 
        $html .= "<h1 class = 'nombre_perfil'> Perfil de @".$usuario."</h1>";  
        $html .= $boton_ajuste; 
        $html.= "</section>"; 

        if($favs){
            $html = "<h1 class = 'texto_infor'> Posts Favoritos de @".$usuario."</h1>"; 
            $posts = Post::obtenerPostsFavPorUser($usuario); 
        }else
            $posts = Post::obtenerPostsDeUsuario($usuario); 
        
        if(!empty($posts)){
            $html .= "<section class = 'listaPost'>";
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
                                         $post->getTexto(), $post->getId(), $usuario);
                }
            $html .= "</section>";

        }else
            $html .= "<section class = 'listaPost'> <h3> No has dado Like (&#10084) a ningún post</h3></section>";
    }else
        $html = "<h1 class = 'texto_infor'>  No estas logead@ </h1>";

    return $html;
}
