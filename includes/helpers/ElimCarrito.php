<?php 

require_once '../Config.php';
require_once CLASSES_PATH . '/Producto.php';
require_once CLASSES_PATH . '/Pedido.php';

$id = $_POST['EliminarID'];
$id_pedido = $_POST['PedidoID'];
$user = null;

if(isset($_SESSION['username']))
    $user = $_SESSION['username'];


if($user){
    $prod = Producto::buscarProductoPorID($id);
    Pedido::quitarProductoPP($prod, $id_pedido);
    $prod->setStock($prod->getStock() + 1);
    Producto::actualiza($prod);
}

header('Location:'. VIEWS_PATH .'/tienda/Carrito.php');
exit();