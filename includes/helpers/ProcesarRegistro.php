<?php

require_once '../../Config.php';
require_once CLASSES_URL . '/Usuario.php'; 

// Datos comunes
$username =  htmlspecialchars($_POST['new_username']);
$nickname = htmlspecialchars($_POST['new_nickname']);
$email = htmlspecialchars($_POST['new_email']);
$password_length = strlen($_POST['new_password']);
$password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
$birthdate = $_POST['new_birthdate'];
$isArtist = boolval($_POST['isArtist']);

// Comprobar datos de usuario
$errors = Usuario::checkUserData($username, $password_length, $email, $birthdate, $isArtist);

if( !empty($errors) ) {
    $_SESSION['error'] = $errors;

    if(!$isArtist)
        header('Location: ' . VIEWS_URL . '/log/SignUpUser.php');
    else
        header('Location: ' . VIEWS_URL . '/log/SignUpArtist.php');
    
    exit();
}

// Datos de artista
$artist_members = '';
if(!$isArtist)
    $artist_members = null;
else
    $artist_members = $_POST['musical_genres'];

// Datos para crear usuario
$parametros = [];
$parametros['username'] = $username;
$parametros['nickname'] = $nickname;
$parametros['password'] = $password;
$parametros['email'] = $email;
$parametros['birthdate'] = $birthdate;
$parametros['isArtist'] = $isArtist;
$parametros['artist_members'] = $artist_members;

// Crear usuario
$usuario = Usuario::createUser($parametros);

// Redirigir al cliente
$_SESSION['username'] = $username; 
header('Location: ' . VIEWS_URL . '/foro/Foro.php');