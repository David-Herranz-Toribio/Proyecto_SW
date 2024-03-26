<?php 

require_once '../Config.php';
require_once RUTA_CLASSES.'/Post.php';
require_once RUTA_CLASSES.'/Usuario.php';

$id = $_POST['id'];
$tx = htmlspecialchars($_POST['postText']);

$post = Post::buscarPostPorID($id);
$post->setTexto($tx);
if ($_FILES['image']['name'] != ''){

    $archivo_nombre = $_FILES['image']['name'];
    $archivo_tipo = $_FILES['image']['type'];
    $archivo_tamaño = $_FILES['image']['size'];
    $archivo_temporal = $_FILES['image']['tmp_name'];

    $directorio_destino = RUTA_IMG.'/postImages/';

    //Nombre con extension
    $ultimo_punto = strrpos($archivo_nombre, '.');
    $extension = substr($archivo_nombre, $ultimo_punto + 1);
    $post_image = uniqid() . '.' . $extension;

    //Ruta de guardado
    $ruta_destino = $directorio_destino . $post_image;
    move_uploaded_file($archivo_temporal, $ruta_destino);
    $post->setImagen($post_image);
}

Post::actualizar($post);

header('Location:'. RUTA_VISTAS_PATH .'/foro/Foro.php');
exit();