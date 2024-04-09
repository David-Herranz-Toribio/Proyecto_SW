<?php 

require_once '../Config.php';
require_once CLASSES_URL . '/Usuario.php';
require_once CLASSES_URL . '/Pedido.php';

//Obtener el input
$username = htmlspecialchars($_POST['username']);
//$username = filter_input(INPUT_POST, $_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS);
$password = $_POST['password'] ?? null;

//Comprobar credenciales
$isValid = Usuario::login($username, $password);

//Iniciar sesion o pedir de nuevo la cuenta
if($isValid){
    $_SESSION['username'] = $username;
    $_SESSION['login'] = true;
    $_SESSION['isArtist'] = Usuario::esArtista($username);
    
    $num = Pedido::numProdporUserPP($username);
    if($num)
        $_SESSION['notif_prod'] = $num;
    
    header('Location: ' . VIEWS_PATH . '/foro/Foro.php');
    exit();
}
else{
    $_SESSION['error'] = true;
    
    header('Location: ' . VIEWS_PATH . '/log/Login.php'); 
    exit();
}