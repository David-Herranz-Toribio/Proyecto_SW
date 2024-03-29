<?php 

require_once "../Config.php";
require_once RUTA_CLASSES.'/Producto.php';
require_once RUTA_CLASSES.'/Pedido.php';

$id = $_POST['Id'];
$cant = $_POST['Cantidad'];
$user = null;

if(isset($_SESSION['username']))
    $user = $_SESSION['username'];

//Log usear or ask again for his account
if($user){
    //añadir like BD
    $producto = Producto::buscarProductoPorID($id);
    $producto->setStock($producto->getStock() - $cant);
    $pedido = Pedido::buscarPedidoPorUser($user);

    if(!$pedido){
        $pedido = Pedido::crearPedido(NULL, $user, 'En proceso', $producto->getPrecio(), NULL);
        $pedido = Pedido::inserta($pedido);
    }

    //Comprobar si mi producto esta asignado a mi pedido
    //if (true){cant++} else{insertarPP} 
    $cantPP = Pedido::consultaPP($pedido->getId(), $id);
    if($cantPP)
        Pedido::actualizaPP($pedido->getId(), $id, $cantPP + $cant);
    else
        Pedido::insertaPP($pedido->getId(), $id, $cant);
}

header('Location: ' .RUTA_VISTAS_PATH. '/tienda/Merch.php');
exit();