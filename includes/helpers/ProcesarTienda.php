<?php

require_once '../Config.php';
require_once CLASSES_URL . '/Producto.php';

$id = $_POST['Id'];
$autor = $_POST['Autor'];
$nombre = htmlspecialchars($_POST['Nombre']);
$descripcion = isset($_POST['Descripcion']) ? htmlspecialchars($_POST['Descripcion']) : "$nombre de $autor"; 
$stock = $_POST['Stock'];
$precio = $_POST['Precio'];
$imagen_ant = $_POST['Imagen_antigua'];

if ($_FILES['Imagen']['name'] != ''){
    $archivo_nombre = $_FILES['Imagen']['name'];
    $archivo_tipo = $_FILES['Imagen']['type'];
    $archivo_tamaño = $_FILES['Imagen']['size'];
    $archivo_temporal = $_FILES['Imagen']['tmp_name'];

    $directorio_destino = IMG_URL . '/prodImages/';

    //Nombre con extension
    $ultimo_punto = strrpos($archivo_nombre, '.');
    $extension = substr($archivo_nombre, $ultimo_punto + 1);
    $imagen = uniqid() . '.' . $extension;

    //Ruta de guardado
    $ruta_destino = $directorio_destino . $imagen;
    move_uploaded_file($archivo_temporal, $ruta_destino);

    // Eliminar archivo anterior si existe
    if (file_exists($directorio_destino . $imagen_ant) && $imagen_ant != 'FotoMerch.png') {
        unlink($directorio_destino . $imagen_ant);
    }
    
}


$producto = SW\classes\Producto::crearProducto($id, $nombre, $descripcion, $imagen ?? $imagen_ant , $autor, $stock, $precio);
$producto->guarda();

header('Location:'. VIEWS_PATH .'/tienda/MiTiendaVista.php'); 
exit(); 