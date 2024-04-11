<?php

require_once '../Config.php';
require_once CLASSES_URL . '/Usuario.php'; 
require_once CLASSES_URL . '/Pedido.php'; 

// Datos comunes
$username =  htmlspecialchars($_POST['new_username']);
$nickname = htmlspecialchars($_POST['new_nickname']);
$email = htmlspecialchars($_POST['new_email']);
$password_length = strlen($_POST['new_password']);
$password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
$birthdate = $_POST['new_birthdate'];
$isArtist = boolval($_POST['isArtist']);


if ($_FILES['image']['name'] != ''){
    $archivo_nombre = $_FILES['image']['name'];
    $archivo_tipo = $_FILES['image']['type'];
    $archivo_tamaño = $_FILES['image']['size'];
    $archivo_temporal = $_FILES['image']['tmp_name'];

    $directorio_destino = IMG_URL . '/profileImages/';

    //Nombre con extension
    $ultimo_punto = strrpos($archivo_nombre, '.');
    $extension = substr($archivo_nombre, $ultimo_punto + 1);
    $profile_image = uniqid() . '.' . $extension;

    //Ruta de guardado
    $ruta_destino = $directorio_destino . $profile_image;
    move_uploaded_file($archivo_temporal, $ruta_destino);
}
else
    $archivo_nombre = 'FotoPerfil.png';

// Comprobar datos de usuario
$errors = Usuario::checkUserData($username, $password_length, $email, $birthdate, $isArtist);

if( !empty($errors) ) {
    $_SESSION['error'] = $errors;

    if(!$isArtist)
        header('Location: ' . VIEWS_PATH . '/log/SignUpUser.php');
    else
        header('Location: ' . VIEWS_PATH . '/log/SignUpArtist.php');
    
    exit();
}

// Datos de artista
$artist_members = '';
if(!$isArtist)
    $artist_members = null;
else{
    $artist_members = $_POST['musical_genres'];
    $_SESSION['isArtist'] = true;
}

$num = Pedido::numProdporUserPP($username);
if($num)
    $_SESSION['notif_prod'] = $num;

// Datos para crear usuario
$parametros = [];
$parametros['username'] = $username;
$parametros['nickname'] = $nickname;
$parametros['password'] = $password;
$parametros['email'] = $email;
$parametros['birthdate'] = $birthdate;
$parametros['isArtist'] = $isArtist;
$parametros['artist_members'] = $artist_members;
$parametros['profile_image'] = $archivo_nombre;

// Crear usuario
$usuario = Usuario::createUser($parametros);

// Redirigir al cliente
$_SESSION['username'] = $username; 
header('Location: ' . VIEWS_PATH . '/foro/Foro.php');
exit();