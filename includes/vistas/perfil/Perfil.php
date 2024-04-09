<?php

require_once '../../Config.php';
require_once CLASSES_URL . '/Post.php';

$usuario = $_GET["user"] ?? NULL;
$favs = $_GET["favs"] ?? NULL;
$content = showProfile($usuario,$favs);

require_once LAYOUT_URL;


function showProfile($usuario, $favs){
    $SettingsImage = IMG_PATH.'/Setting_icon__.png';
    

    if(!isset($_SESSION['username']) && !$usuario) {
        $html = "<h1 class = 'texto_infor'>  No estas logead@ </h1>";
    }

    else {
        $html = "<section class = 'datos_perfil'>";
        if(isset($_SESSION['username']) && ($usuario== $_SESSION['username'] || !$usuario)){ //Tu perfil
            $html .= "<h1 class = 'nombre_perfil'> Tu Perfil</h1>";
            $html .= <<<EOS
            <div class="datos_perfil">
            <a href="AjustePerfil.php">
            <img src='$SettingsImage' alt="Modificar Perfil" height="45" width="50">
            </a>
            </div>
        
            EOS;
            $html.= "</section>"; 

            if($favs){
                $html = "<h1 class = 'texto_infor'> Posts Favoritos de @".$usuario."</h1>"; 
                $posts = Post::obtenerPostsFavPorUser($usuario); 
            }else
                $posts = Post::obtenerPostsDeUsuario($usuario); 
            
        }
    
        else if($usuario){
            
            $html.= other_user_view($usuario); 
            $posts = Post::obtenerPostsDeUsuario($usuario); 
        }
        

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


    }

    return $html; 
}


/*
function showProfile($usuario,$favs){

    
    $boton_ajuste= ''; 


    if(!$usuario){ //Tu perfil
        if (isset($_SESSION['username'])) //Hay sesion iniciada
            $usuario = $_SESSION['username'];
    }

    if($usuario) { 

        $html = "<section class = 'datos_perfil'>"; 

        if(isset($_SESSION['username']) && $usuario ==  $_SESSION['username']){ //TU PERFIL
            $boton_ajuste = <<<EOS
            
            <div class="datos_perfil">
                <a href="AjustePerfil.php">
                    <img src='$SettingsImage' alt="Modificar Perfil" height="45" width="50">
                </a>
            </div>
           
            EOS;
            $html .= "<h1 class = 'nombre_perfil'> Tu Perfil</h1>";
        }
        else{ // PERFIL DE OTRO

            $html .= "<h1 class = 'nombre_perfil'> Perfil de @".$usuario."</h1>";  
            //FUNCIONALIDAD DE SEGUIR/DEJAR DE SEGUIR
            
        }
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

    }
    
    
    else //NO SE HA INICIADO SESION
        $html = "<h1 class = 'texto_infor'>  No estas logead@ </h1>";

    return $html;
}

*/

function other_user_view($username){
  
    $html = "<h1 class = 'nombre_perfil'> Perfil de @".$username."</h1>";  
    if(isset($_SESSION['username'])){
        $us= Usuario::buscaUsuario($_SESSION['username']); 

        if($us->estaSiguiendo($username)){ //Comprobamos si ya seguimos al user del perfil en concreto
            $textoBoton= 'Dejar de seguir';
            $seguir= false;
        }
    
        else {
             $textoBoton= 'Seguir';
             $seguir= true; 
        }
    
         $rutaSeguimiento= HELPERS_PATH.'/ProcesarSeguimiento.php'; 
        $rutaRetorno= VIEWS_PATH.'/perfil/Perfil.php'; 
     
        $html .= <<<EOS
    
        <div class= "datos_perfil"> 
        <form action = $rutaSeguimiento method= "post"> 
    
        <input type = "hidden" name= "return" value= $rutaRetorno?user=$username>
        <input type = "hidden" name = "id" value = $username>
        <input type = "hidden" name = "no_seguir/seguir" value= $seguir>
        <button type="submit"> $textoBoton </button>
    
        </form>  
    
        </div> 
        EOS;
    }
   
    return $html; 
}