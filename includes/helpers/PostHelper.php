<?php

require_once CLASSES_URL . '/Post.php';
require_once CLASSES_URL . '/Usuario.php';
require_once CLASSES_URL . '/FormularioRespuesta.php'; 

function creacionPostHTML($autor, $image, $likes, $texto, $id, $id_padre, $yoYYoMismo){

    $rutaPerfil = VIEWS_PATH . '/perfil/Perfil.php';

    //Imagen de usuario junto a su username
    $user = SW\classes\Usuario::buscaUsuario($autor);
    $rutaPFP = IMG_PATH . '/profileImages/'.$user->getPhoto();
    
    $user_info= <<<EOS
    <div class="user_info">
    <div class= 'user_image'> 
    <img alt="user_info" src=$rutaPFP width="50px" height="50px">
    </div>

    <div>
    <a href= "$rutaPerfil?user=$autor" name="user">@$autor</a> 
    </div>
    EOS; 

    if ($yoYYoMismo == $autor || (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == true)){
        $rutaMod = VIEWS_PATH . '/foro/ModificarVista.php';
        $rutaEliminar = HELPERS_PATH . '/ProcesarEliminar.php';

        $user_info .= <<<EOS2
        <div class='modElim'> 
        <form action=$rutaMod method="post">
            <input type = "hidden" name = "idPadre" value= '$id_padre'>
            <input type = "hidden" name = "idPost" value = '$id'>
            <button type = "submit"> &#9998 </button>
        </form>

        <form action= $rutaEliminar method="post">
            <input type="hidden" name="EliminarID" value= '$id'>
            <button type="submit"> &#10060</button>
        </form>
        </div> 
        EOS2;
    }


    //Texto del post
    $post_info =<<<EOS3
    </div>
    <div class="post_info">
        <p>$texto</p> 
    </div>
    EOS3;

    //Imagen del post
    $rutaImagen = IMG_PATH . '/postImages/'.$image;
    $post_image = "";

    if(!empty($image)){
        $post_image =<<<EOS4
        <div class="post_image">
            <img alt = "post_image" src = $rutaImagen width = "70" heigth = "70">
        </div>
        EOS4;
    }

    $rutaLike = HELPERS_PATH . '/ProcesarLike.php';
    $rutaRespuestas = VIEWS_PATH . '/foro/RespuestasForo.php';
    $rutaAdd = VIEWS_PATH . '/foro/AddForo.php';


    if(!$yoYYoMismo){
        $responder = ''; 
    }

    else {
        $form= new FormularioRespuesta($id);
        $responder= $form->gestiona(); 
    }

    $botones = <<<EOS6
    <div class='botones_mensaje'>
    <form action = $rutaLike method = "post">
        <input type = "hidden" name = "likeId" value = "$id">
        <button type="submit">$likes &#9834 </button>
    </form>

    <form action=$rutaRespuestas method = "post">
        <input type = "hidden" name = "respuestasId" value = "$id">
        <button type = "submit">&#128172</button>
    </form>
    </div>
    $responder
    EOS6;

    $html =<<<EOS7
        <article class = "estiloPost">
            $user_info
            $post_info
            $post_image
            $botones
        </article>
    EOS7;

    return $html;
}
function creacionPubliHTML(){
    $html= <<<EOS
    <article class = "estiloPost">
        <div>
            <p>¡Desbloquea todo un mundo de beneficios con nuestra suscripción premium!</p>
            <p>Accede a contenido exclusivo, funciones avanzadas y una experiencia sin interrupciones. ¡Únete ahora y lleva tu experiencia al siguiente nivel!</p>
        </div>
    </article>
    EOS; 

    return $html;
}

function showMainPosts($user, $opcion){

    // Mostrar el header del perfil -> imagen, fecha de nacimiento, nickname, username, boton de follow, descripcion + [opciones]
    $html = displayContentMain($user, $opcion);
    return $html;
}

function displayContentMain($user, $opcion){

    $html = '';
    switch($opcion) {

        case NULL:
        case 'EXPLORER':
            $html = showTestPosts($user);
            break; 
        
        case 'FOLLOWED':
            $html = showFollowedPeoplePosts($user); 
            break; 

        default:
            $html = 'VISTA NO RECONOCIDA';
            break;
    }
    return $html;
}

function displayExplorerButton(){
    $view_path = VIEWS_PATH . '/foro/Foro.php';
    $value = 'EXPLORER';

    $html =<<<EOS
    <div class='opcion_posts'>
    <form action=$view_path method='get'>
        <input type='hidden' name='opcion' value='$value'>
        <button type='submit'> Explorar </button>
    </form>
    </div>
    EOS;

    return $html;
}

function displayFollowedButton(){
    $view_path = VIEWS_PATH . '/foro/Foro.php';
    $value = 'FOLLOWED';

    $html =<<<EOS
    <div class='opcion_posts'>
    <form action=$view_path method='get'>
        <input type='hidden' name='opcion' value='$value'>
        <button type='submit'> Contenido (seguidos)  </button>
    </form>
    </div>
    EOS;
    return $html;
}



function showResp($id_post, $yoYYoMismo){

    $rutaNoLog = VIEWS_PATH . '/log/Login.php';

    if (!isset($_SESSION['username']))
        $html= "<p class = 'texto_infor'> No estas logead@,  <a href = $rutaNoLog> <strong>  pulsa aqui para iniciar sesion </strong> </a> </p>";
    else{
        $post_aux = SW\classes\Post::buscarPostPorID($id_post); 

        $html = "<h1 class = 'texto_infor'> Respuestas a @".$post_aux->getAutor(). "</h1>";
        $html .= "<section class = 'listaPost' id='respuestas'>";
        $html .= "<section  id='respuestas'>";
        $html .= "<div id = 'headPost'>";
        $html .= creacionPostHTML($post_aux->getAutor(), $post_aux->getImagen(), $post_aux->getLikes(),
                                  $post_aux->getTexto(), $post_aux->getId(), $post_aux->getPadre(), $yoYYoMismo);
        $html .= "</div>";

        $posts = SW\classes\Post::obtenerListaDePosts($id_post); 
        if(!empty($posts)){
            if (isset($_GET['query'])) {
                $textoBusqueda = $_GET['query'];
                $posts = SW\classes\Post::LupaUsuarioPostExistentes($posts, $textoBusqueda);
            }   
        }

        $html.= "<div id='post_respuestas'>"; 


        foreach($posts as $post){
            $html .= creacionPostHTML($post->getAutor(), $post->getImagen(), $post->getLikes(),
                                      $post->getTexto(), $post->getId(), $post->getPadre(), $yoYYoMismo);
        }
        $html.= "</div>"; 
        $html.= "</section> ";
    }

    return $html;
}

function showTestPosts($yoYYoMismo){

    $rutaPublicar = VIEWS_PATH . '/foro/CrearPost.php';
    $content = "<h1 class = 'texto_infor'> Posts </h1>";

    $content .= "<section class='default'>";
    $content .= displayExplorerButton();   

    if(isset($_SESSION['username'])){ //Si no se ha iniciado sesion no puedes publicar

        $content .= displayFollowedButton();
        $content .= <<< EOS
        <form class= 'boton_publicar' action = $rutaPublicar method = "post">
        <button type = "submit">Publicar</button>
        </form>
        EOS; 
    }

    $content .= "<section class = 'listaPost'>";
    $posts = SW\classes\Post::obtenerListaDePosts();
    if(!empty($posts)){
        if (isset($_GET['query'])) {
            $textoBusqueda = $_GET['query'];
            $posts = SW\classes\Post::LupaUsuarioPostExistentes($posts, $textoBusqueda);
        }   
    }
    $contador = 1;
    foreach($posts as $post){
        $content .= creacionPostHTML($post->getAutor(), $post->getImagen(), $post->getLikes(),
                                     $post->getTexto(), $post->getId(), $post->getPadre(), $yoYYoMismo); 
        if (!isset($_SESSION['isSub']) || $_SESSION['isSub'] == false){
            if ($contador == 3){
                $content .= creacionPubliHTML();
            }
            $contador++;
        }  
    }
    $content .= "</section>";

    return $content;
}

function showFollowedPeoplePosts($yoYYoMismo){

    $rutaPublicar = VIEWS_PATH . '/foro/CrearPost.php';
    $content = "<h1 class = 'texto_infor'> Posts (Personas que sigues) </h1>";

    $content .= "<section class='default'>";
    $content .= displayExplorerButton();

    if(isset($_SESSION['username'])){ //Si no se ha iniciado sesion no puedes publicar 

        $content .= displayFollowedButton();
        $content .= <<< EOS
        <form class= 'boton_publicar' action = $rutaPublicar method = "post">
        <button type = "submit">Publicar</button>
        </form>
        EOS; 
    }
    $content .= "<section class = 'listaPost'>";
    $user = SW\classes\Usuario::buscaUsuario($yoYYoMismo);
    $lista_seguidos = $user->obtenerListaSeguidos();
    $posts = [];
    foreach($lista_seguidos as $seguido){
        $postsSeguido = SW\classes\Post::obtenerPostsDeUsuario($seguido);
        $posts = array_merge($posts, $postsSeguido);
    }
    if(!empty($posts)){
        if (isset($_GET['query'])) {
            $textoBusqueda = $_GET['query'];
            $posts = SW\classes\Post::LupaUsuarioPostExistentes($posts, $textoBusqueda);
        }   
    }
    foreach($posts as $post){
        $content .= creacionPostHTML($post->getAutor(), $post->getImagen(), $post->getLikes(),
                                     $post->getTexto(), $post->getId(), $post->getPadre(), $yoYYoMismo);   
    }
    $content .= "</section>";
    return $content;
}


function modificatePost($postText, $postId){

    $rutaMod = HELPERS_PATH . '/ProcesarModificacion.php';
    $html =<<<EOS
    <fieldset>
        <legend><strong> Modificacion </strong></legend>
        <form name = "datos_post" action = $rutaMod method = "post" enctype = "multipart/form-data">
            <input type = "hidden" name = "id" value = $postId>
            Mensaje: <textarea name = "postText" required style = "resize: none;">$postText</textarea><br><br>
            <label>Imagen:<input type = "file" name = "image" accept = "image/*"></label><br>
            <br>
            Publicar <input type = "submit">
        </form>
    </fieldset>
    EOS;
    
    $post_modi= <<<EOS
        <section class = 'formulario_style'> 
            $html
        </section> 

    EOS; 

    return $post_modi;
}
