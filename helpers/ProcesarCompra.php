<?php
require_once '../Config.php';
require_once RUTA_CLASSES.'/Usuario.php'; 
require_once RUTA_CLASSES.'/Pedido.php'; 

$id_user= $_POST['id_user']; 
$karma= $_POST['nuevo_karma']; 
$total= $_POST['precio_total']; 

$usu_mod= Usuario::buscaUsuario($id_user); 
$usu_mod->setKarma($karma);
Usuario:: actualiza($usu_mod); 

$pedido = Pedido::buscarPedidoPorUser($id_user);
$pedido->setEstado("Procesado");
$pedido->setTotal($total);
Pedido::actualiza($pedido);
$_SESSION['notif_prod'] = 0;
 
header('Location: '.RUTA_VISTAS_PATH.'/tienda/Merch.php'); 
exit();