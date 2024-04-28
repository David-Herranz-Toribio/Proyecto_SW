<?php 

require_once '../Config.php';
require_once CLASSES_URL . '/Producto.php';

$id = $_POST['EliminarID'];
$user = null;

if(isset($_SESSION['username']))
    $user = $_SESSION['username'];


if($user){
    $prod = SW\classes\Producto::buscarProductoPorID($id);
    $prod->borrarProducto();
}

header('Location:'. VIEWS_PATH .'/tienda/MiTiendaVista.php');
exit();