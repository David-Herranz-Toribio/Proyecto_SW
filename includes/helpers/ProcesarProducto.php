<?php 

require_once "../../Config.php";
require_once CLASSES_URL . '/Producto.php';
require_once CLASSES_URL . '/Pedido.php';

$id = $_POST['Id'];
$cant = $_POST['Cantidad'];
$user = null;

if(isset($_SESSION['username']))
    $user = $_SESSION['username'];

//si esta registrado el usuario
if($user){
    //obtener producto y actualizar stock

    $producto = Producto::buscarProductoPorID($id);
    $producto->setStock($producto->getStock() - $cant);
    Producto::actualiza($producto);
    $pedido = Pedido::buscarPedidoPorUser($user);

    if(!$pedido){
        $pedido = Pedido::crearPedido(NULL, $user, 'En proceso', $producto->getPrecio() * $cant, NULL);
        $pedido = Pedido::inserta($pedido);
    }else{
        $pedido->setTotal($pedido->getTotal() + ($producto->getPrecio() * $cant) );
        $pedido = Pedido::actualiza($pedido);
    }
    //Comprobar si mi producto esta asignado a mi pedido
    //if (true){cant++} else{insertarPP} 
    $cantPP = Pedido::consultaPP($pedido->getId(), $id);
    if($cantPP)
        Pedido::actualizaPP($pedido->getId(), $id, $cantPP + $cant);
    else{
        Pedido::insertaPP($pedido->getId(), $id, $cant);
        
        if(isset($_SESSION['notif_prod']))
            $_SESSION['notif_prod'] = $_SESSION['notif_prod'] + 1;
        else
            $_SESSION['notif_prod'] = 1;

    }
}

header('Location: ' . VIEWS_PATH . '/tienda/Merch.php');
exit();