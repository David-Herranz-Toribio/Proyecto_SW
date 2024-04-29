<?php

require_once '../../Config.php';

function generatePostPublicationHTML($id_padre = 'NULL'){

    $ruta = VIEWS_PATH . '/foro/AddForo.php';
    $html = "<section class='default'>";
    $html .=<<<EOS
    <fieldset>
        <legend ><strong> Nueva Publicación </strong></legend>
        <form name = "datos_post" action = $ruta method = "post" enctype = "multipart/form-data">
            <input type = "hidden" name = "id_padre" value = "$id_padre">
            Mensaje: <textarea name = "post_text" required style = "resize: none; "></textarea><br><br>
            Imagen:<input type = "file" name = "image" accept = "image/*">
            <br><br><br>
            <button type="submit"> Publicar </button>
        </form>
    </fieldset>
    EOS;

    $publicacion = '<section class="formulario_style">' . $html . '</section>';

    return $publicacion;
}