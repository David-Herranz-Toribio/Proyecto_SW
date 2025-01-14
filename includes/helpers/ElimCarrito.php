<?php 

require_once '../Config.php';
require_once CLASSES_URL . '/Producto.php';
require_once CLASSES_URL . '/Pedido.php';

$id = $_POST['EliminarID'];
$id_pedido = $_POST['PedidoID'];
$user = null;

if(isset($_SESSION['username']))
    $user = $_SESSION['username'];

if($user){
    $prod = SW\classes\Producto::buscarProductoPorID($id);
    if(SW\classes\Pedido::quitarProductoPP($prod, $id_pedido)){
        $_SESSION['notif_prod'] = $_SESSION['notif_prod'] - 1;
    }
    $prod->setStock($prod->getStock() + 1);
    SW\classes\Producto::actualiza($prod);
}

header('Location:'. VIEWS_PATH .'/tienda/Carrito.php');
exit();