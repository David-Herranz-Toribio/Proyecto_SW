<?php

require_once CLASSES_URL . '/Post.php';
require_once CLASSES_URL . '/Usuario.php';
require_once CLASSES_URL . '/FormularioRespuesta.php';
require_once CLASSES_URL . '/FormularioPost.php'; 

function crearFormReseña($id, $tipo, $yoYYoMismo){
    $content =  "<h2>Reseñas</h2>";

    if($tipo == "cancion")
        $form = new FormularioPost(null, null, null, $id);    
    else if($tipo == "producto"){
        $form = new FormularioPost(null, null, $id, null); 
    }
    
    $content .= $form->gestiona();                                   


    $listaPosts = SW\classes\Post::obtenerListaDeReseñas($tipo, $id);
    foreach($listaPosts as $post_aux){
        $content .= creacionPostHTML($post_aux->getAutor(), $post_aux->getImagen(), $post_aux->getLikes(),
                                     $post_aux->getTexto(), $post_aux->getId(), $post_aux->getPadre(), $yoYYoMismo);
    }
    return $content;
}
function creacionPostHTML($autor, $image, $likes, $texto, $id, $id_padre, $yoYYoMismo){

    $rutaPerfil = VIEWS_PATH . '/perfil/Perfil.php';

    //Imagen de usuario junto a su username
    $user = SW\classes\Usuario::buscaUsuario($autor);
    $rutaPFP = IMG_PATH . '/profileImages/'.$user->getPhoto();
    
    $user_info= <<<EOS
    <div class="user_info">
        <div class='user_image'> 
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
    $user_info .= "</div>";

    // Texto del post
    $post_info =<<<EOS3
    <div class="post_info">
        <p> $texto </p> 
    </div>
    EOS3;

    //Imagen del post
    $rutaImagen = IMG_PATH . '/postImages/'.$image;
    $post_image = "";

    if(!is_null($image) && file_exists(IMG_URL . '/postImages/' . $image) ){
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
        $form= new FormularioRespuesta($id, '/foro/Foro.php');
        $responder= $form->gestiona(); 
    }

    $botones = <<<EOS6
    <div class='botones_mensaje'>
    <form action = $rutaLike method = "post">
        <input type = "hidden" name = "likeId" value = "$id">
        <button type="submit">$likes &#9834 </button>
    </form>

    <form action=$rutaRespuestas method = "post">
        <input type = "hidden" name = "id_padre" value = "$id">
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

function creacionPubliHTML2(){

    $rutaSus = VIEWS_PATH . "/tienda/Suscripcion.php";
    $rutaImg = IMG_PATH . "/FotoSuscripcion.png";
    $html = <<<EOS
    <article class = "estiloPost" >
        <a href="$rutaSus">
            <div class="publicidad"  >
                <p>¡Desbloquea todo un mundo de beneficios con nuestra suscripción premium!</p>
                <img src=$rutaImg height="200" width="200" alt="Foto de suscripcion">
                <p>Accede a contenido exclusivo, funciones avanzadas y una experiencia sin interrupciones. ¡Únete ahora y lleva tu experiencia al siguiente nivel!</p>
            </div>
        </a>
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
            $html = showTestPosts($user, true);
            break; 
        
        case 'FOLLOWED':
            $html = showTestPosts($user, false);
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
    $BrowserImage = IMG_PATH . '/Browser.png';

    $html =<<<EOS
    <div class='opcion_posts'>
        <form action="$view_path" method="get">
            <input type="hidden" name="opcion" value="$value">
            <button class="player-button" type="submit">
                <img src="$BrowserImage" alt="Explorar" height="38" width="38">
            </button>
        </form>
    </div>
    EOS;
    return $html;
}

function displayFollowedButton(){

    $view_path = VIEWS_PATH . '/foro/Foro.php';
    $value = 'FOLLOWED';
    $UsersImage = IMG_PATH . '/Users_.png';
    $html =<<<EOS
    <div class='opcion_posts'>
        <form action="$view_path" method="get">
            <input type="hidden" name="opcion" value="$value">
            <button class="player-button" type="submit">
            <img src="$UsersImage" alt="Contenido (seguidos)" height="54" width="54">
            </button>
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

function showTestPosts($yoYYoMismo, $isTest){

    $rutaPublicar = VIEWS_PATH . '/foro/CrearPost.php';
    if ($isTest) 
        $content = "<h1 class='texto_infor'> Posts </h1>";
    else 
        $content = "<h1 class='texto_infor'> Posts (Personas que sigues) </h1>";
    
    $content .= "<div class='botonesPost'>";
    $content .= displayExplorerButton();
    if (isset($_SESSION['username'])) {
        $content .= displayFollowedButton();
        $content .= <<< EOS
        <form class='boton_publicar' action='$rutaPublicar' method="post">
            <button type="submit">Publicar</button>
        </form>
        EOS; 
    }
    $content .= "</div>";
    $content .= "<section class='listaPost'>";
    
    if(!$isTest) {
        $user = SW\classes\Usuario::buscaUsuario($yoYYoMismo);
        $lista_seguidos = $user->obtenerListaSeguidos();
        $posts = [];
        foreach($lista_seguidos as $seguido){
            $postsSeguido = SW\classes\Post::obtenerPostsDeUsuario($seguido);
            $posts = array_merge($posts, $postsSeguido);
        }
    }
    else 
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
                $content .= creacionPubliHTML2();
                $contador = 1;

            }
            else
                $contador++;
        }  
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
