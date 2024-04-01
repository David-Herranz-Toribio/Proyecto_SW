<?php

require_once '../Config.php';
require_once RUTA_CLASSES.'/Usuario.php'; 

// Datos comunes
$username =  htmlspecialchars($_POST['new_username']);
$nickname = htmlspecialchars($_POST['new_nickname']);
$email = htmlspecialchars($_POST['new_email']);
$password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
$birthdate = $_POST['new_birthdate'];
$isArtist = boolval($_POST['isArtist']);
$errors = [];

// Datos de artista
if(!$isArtist)
    $artist_members = null;
else
    $artist_members = $_POST['musical_genres'];


// Comprobar datos de usuario
$correct = Usuario::checkUserData($username, $nickname, $password, $email, $birthdate, $isArtist, $artist_members);

if(!$correct){
    $_SESSION['error'] = true;
    header('Location: ' . RUTA_VISTAS_PATH . '/log/SignUpUser.php');
    exit();
}

// Crear usuario
$usuario = Usuario::createUser($username, $nickname, $password, $email, $birthdate, $isArtist, $artist_members, $errors);

// Redirigir al cliente
$_SESSION['username'] = $username; 
header('Location: ' . RUTA_VISTAS_PATH . '/foro/Foro.php');