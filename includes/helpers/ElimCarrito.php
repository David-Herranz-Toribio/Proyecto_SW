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
    $prod = es\ucm\fdi\aw\Producto::buscarProductoPorID($id);
    if(es\ucm\fdi\aw\Pedido::quitarProductoPP($prod, $id_pedido)){
        $_SESSION['notif_prod'] = $_SESSION['notif_prod'] - 1;
    }
    $prod->setStock($prod->getStock() + 1);
    es\ucm\fdi\aw\Producto::actualiza($prod);
}

header('Location:'. VIEWS_PATH .'/tienda/Carrito.php');
exit();