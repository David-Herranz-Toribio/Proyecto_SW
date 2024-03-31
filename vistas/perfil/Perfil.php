<?php

require_once '../../Config.php';
require_once RUTA_CLASSES.'/Post.php';

$usuario = $_GET["user"] ?? NULL;
$favs = $_GET["favs"] ?? NULL;
$content = showProfile($usuario,$favs);

require_once RUTA_LAYOUTS;

function showProfile($usuario,$favs){
    $SettingsImage = RUTA_IMG_PATH.'/Setting_icon__.png';
    if(!$usuario){
        if (isset($_SESSION['username']))
            $usuario = $_SESSION['username'];
    }

    if($usuario) {
        $html= "<section class = 'datos_perfil'>"; 
        $html .= "<h1 class = 'nombre_perfil'> Perfil de @".$usuario."</h1>"; 
        
        $html .= <<<EOS
        <p>
        <section class="datos_perfil">
        <a href="AjustePerfil.php">
            <img src='$SettingsImage' alt="Modificar Perfil" height="45" width="50">
        </a>
        </section>
        </p>
        EOS; 

        $html.= "</section>"; 

        if($favs){
            $html = "<h1 class = 'texto_infor'> Posts Favoritos de @".$usuario."</h1>"; 
            $posts = Post::obtenerPostsFavPorUser($usuario); 
        }else
            $posts = Post::obtenerPostsDeUsuario($usuario); 
        
        if(!empty($posts)){
            $html .= "<section class = 'listaPost'>";
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
