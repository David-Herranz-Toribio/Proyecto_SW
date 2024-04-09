<?php

require_once '../Config.php';
require_once CLASSES_URL . '/Producto.php';

$autor = $_POST['Autor'];
$nombre = htmlspecialchars($_POST['Nombre']);
$descripcion = isset($_POST['Descripcion']) ? htmlspecialchars($_POST['Descripcion']) : "$nombre de $autor"; 
$stock = $_POST['Stock'];
$precio = $_POST['Precio'];

if ($_FILES['Imagen']['name'] != ''){
    $archivo_nombre = $_FILES['Imagen']['name'];
    $archivo_tipo = $_FILES['Imagen']['type'];
    $archivo_tamaño = $_FILES['Imagen']['size'];
    $archivo_temporal = $_FILES['Imagen']['tmp_name'];

    $directorio_destino = IMG_PATH . '/prodImages/';

    //Nombre con extension
    $ultimo_punto = strrpos($archivo_nombre, '.');
    $extension = substr($archivo_nombre, $ultimo_punto + 1);
    $imagen = uniqid() . '.' . $extension;

    //Ruta de guardado
    $ruta_destino = $directorio_destino . $post_image;
    move_uploaded_file($archivo_temporal, $ruta_destino);
}
else
    $imagen = false;

$producto = Producto::crearProducto(NULL, $nombre, $descripcion, $imagen, $autor, $stock, $precio);
$producto->guarda();

header('Location:'. VIEWS_PATH .'/tienda/MiTiendaVista.php'); 
exit(); 