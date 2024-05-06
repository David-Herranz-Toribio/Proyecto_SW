<?php
require_once '../Config.php';
require_once CLASSES_URL . '/Usuario.php'; 
require_once CLASSES_URL . '/Pedido.php'; 

$id_user = $_POST['id_user']; 
$karma = $_POST['nuevo_karma']; 
$total = $_POST['precio_total']; 

$usu_mod = SW\classes\Usuario::buscaUsuario($id_user); 
$usu_mod->setKarma($karma);
$usu_mod->actualiza(); 

$pedido = SW\classes\Pedido::buscarPedidoPorUser($id_user);
$pedido->setEstado("Procesado");
$pedido->setTotal($total);
SW\classes\Pedido::actualiza($pedido);
$_SESSION['notif_prod'] = 0;
 
header('Location: ' . VIEWS_PATH . '/tienda/Merch.php'); 
exit();