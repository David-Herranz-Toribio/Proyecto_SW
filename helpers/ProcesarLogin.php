<?php 

require_once '../Config.php';
require_once RUTA_CLASSES . '/Usuario.php';

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
    
    header('Location: ' . RUTA_VISTAS_PATH . '/foro/Foro.php');
    exit();
}
else{
    $_SESSION['error'] = true;
    
    header('Location: ' . RUTA_VISTAS_PATH . '/log/Login.php'); 
    exit();
}