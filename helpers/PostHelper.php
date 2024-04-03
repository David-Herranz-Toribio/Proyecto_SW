<?php

require_once RUTA_CLASSES.'/Post.php';

function creacionPostHTML($autor, $image, $likes, $texto, $id, $yoYYoMismo){

    $rutaPFP = RUTA_IMG_PATH.'/FotoPerfil.png';
    $rutaPerfil = RUTA_VISTAS_PATH.'/perfil/Perfil.php';

    //Imagen de usuario junto a su username
    $user_info =<<<EOS
    <div class="user_info">
        <img alt = "user_info" src= $rutaPFP width="50px" height="50px">
        <div><a href= "$rutaPerfil?user=$autor" name= "user">@$autor</a> </div>
    </div>
    EOS;

    //Texto del post
    $post_info =<<<EOS2
    <div class="post_info">
        <p>$texto</p> 
    </div>
    EOS2;

    //Imagen del post
    $rutaImagen = RUTA_IMG_PATH.'/postImages/'.$image;
    $post_image = "";

    if(!empty($image)){
        $post_image =<<<EOS3
        <div class="post_image">
            <img alt = "post_image" src = $rutaImagen width = "70" heigth = "70">
        </div>
        EOS3;
    }

    $rutaLike = RUTA_HELPERS_PATH.'/ProcesarLike.php';
    $rutaRespuestas = RUTA_VISTAS_PATH.'/foro/RespuestasForo.php';
    $rutaAdd = RUTA_VISTAS_PATH.'/foro/AddForo.php';
    
    //Likes, respuestas y responder
    /*
    if (soy admin){

    }
    */
    $botones = '';
    if ($yoYYoMismo == $autor){
        $rutaMod = RUTA_VISTAS_PATH.'/foro/ModificarVista.php';
        $rutaEliminar = RUTA_HELPERS_PATH.'/ProcesarEliminar.php';

        $botones .= <<<EOS4
        <form action = $rutaMod method="post">
            <input type = "hidden" name = "ModificarID" value = "$id">
            <button type = "submit"> Modificar</button>
        </form>

        <form action= $rutaEliminar method="post">
            <input type="hidden" name="EliminarID" value= '$id'>
            <button type="submit"> Eliminar</button>
        </form>
        EOS4;
    }

    $botones .= <<<EOS5
    <form action = $rutaLike method = "post">
        <input type = "hidden" name = "likeId" value = "$id">
        <button type="submit">$likes &#9834 </button>
    </form>

    <form action = $rutaRespuestas method = "post">
        <input type = "hidden" name = "respuestasId" value = "$id">
        <button type = "submit">Ver Respuestas &#128269</button>
    </form>

    <form action = $rutaAdd method = "post" enctype = "multipart/form-data">
        <input type = "hidden" name = "id_padre" value = "$id">
        <details>
            <summary>Responder &#10149; </summary>
            <label>Respuesta:<input type = "text" name = "post_text" required></label><br>
            <label>Imagen:<input type = "file" name = "image" accept = "image/*"></label><br>
            <button type = "submit">Enviar respuesta</button>
        </details>
    </form>
    EOS5;

    $html =<<<EOS6
        <article class = "estiloPost">
            $user_info
            $post_info
            $post_image
            $botones
        </article>
    EOS6;

    return $html;
}

function showResp($id_post, $yoYYoMismo){

    $rutaNoLog = RUTA_VISTAS_PATH.'/log/Login.php';

    if (!isset($_SESSION['username']))
        $html= "<p class = 'texto_infor'> No estas logead@,  <a href = $rutaNoLog> <strong>  pulsa aqui para iniciar sesion </strong> </a> </p>";
    else{
        $post_aux= Post::buscarPostPorID($id_post); 

        $html = "<h1 class = 'texto_infor'> Respuestas a @".$post_aux->getAutor(). "</h1>";
        $html .= "<section class = 'listaPost'>";
        $html .= "<div id = 'headPost'>";
        $html .= creacionPostHTML($post_aux->getAutor(), $post_aux->getImagen(), $post_aux->getLikes(),
                                  $post_aux->getTexto(), $post_aux->getId(), $yoYYoMismo);
        $html .= "</div>";

        $posts = Post::obtenerListaDePosts($id_post); 
        if(!empty($posts)){
            if (isset($_GET['query'])) {
                $textoBusqueda = $_GET['query'];
                $posts = Post::LupaUsuarioPostExistentes($posts, $textoBusqueda);
            }   
        }

        foreach($posts as $post){
            $html .= creacionPostHTML($post->getAutor(), $post->getImagen(), $post->getLikes(),
                                      $post->getTexto(), $post->getId(), $yoYYoMismo);
        }
        $html .= "</section> ";
    }

    return $html;
}

function showTestPosts($yoYYoMismo){
    $rutaPublicar = RUTA_VISTAS_PATH.'/foro/CrearPost.php';
    $content = "<h1 class = 'texto_infor'> Posts </h1>";

    if(isset($_SESSION['username'])){ //Si no se ha iniciado sesion no puedes publicar 
        $content .= <<< EOS
        <form class= 'boton_publicar' action = $rutaPublicar method = "post">
        <button type = "submit">Publicar</button>
        </form>
        EOS; 
    }

    $content .= "<section class = 'listaPost'>";
    $posts = Post::obtenerListaDePosts();
    if(!empty($posts)){
        if (isset($_GET['query'])) {
            $textoBusqueda = $_GET['query'];
            $posts = Post::LupaUsuarioPostExistentes($posts, $textoBusqueda);
        }   
    }
    foreach($posts as $post){
        $content .= creacionPostHTML($post->getAutor(), $post->getImagen(), $post->getLikes(),
                                     $post->getTexto(), $post->getId(), $yoYYoMismo);   
    }
    $content .= "</section>";

    return $content;
}

function modificatePost($postText, $postId){

    $rutaMod = RUTA_HELPERS_PATH.'/ProcesarModificacion.php';
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