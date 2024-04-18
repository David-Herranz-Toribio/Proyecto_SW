<?php 

require_once "../Config.php";
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

    $producto = es\ucm\fdi\aw\Producto::buscarProductoPorID($id);
    $producto->setStock($producto->getStock() - $cant);
    es\ucm\fdi\aw\Producto::actualiza($producto);
    $pedido = es\ucm\fdi\aw\Pedido::buscarPedidoPorUser($user);

    if(!$pedido){
        $pedido = es\ucm\fdi\aw\Pedido::crearPedido(NULL, $user, 'En proceso', $producto->getPrecio() * $cant, NULL);
        $pedido = es\ucm\fdi\aw\Pedido::inserta($pedido);
    }else{
        $pedido->setTotal($pedido->getTotal() + ($producto->getPrecio() * $cant) );
        $pedido = es\ucm\fdi\aw\Pedido::actualiza($pedido);
    }
    //Comprobar si mi producto esta asignado a mi pedido
    //if (true){cant++} else{insertarPP} 
    $cantPP = es\ucm\fdi\aw\Pedido::consultaPP($pedido->getId(), $id);
    if($cantPP)
        es\ucm\fdi\aw\Pedido::actualizaPP($pedido->getId(), $id, $cantPP + $cant);
    else{
        es\ucm\fdi\aw\Pedido::insertaPP($pedido->getId(), $id, $cant);
        
        if($_SESSION['notif_prod'] >= 1)
            $_SESSION['notif_prod'] = $_SESSION['notif_prod'] + 1;
        else
            $_SESSION['notif_prod'] = 1;

    }
}

header('Location: ' . VIEWS_PATH . '/tienda/Merch.php');
exit();