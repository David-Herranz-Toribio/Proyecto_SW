<?php

require_once '../Config.php';
require_once RUTA_CLASSES.'/Usuario.php'; 

//Opciones comunes
$username =  htmlspecialchars($_POST['new_username']);
$nickname = htmlspecialchars($_POST['new_nickname']);
$email = htmlspecialchars($_POST['new_email']);
$password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
$birthdate = $_POST['new_birthdate'];
$isArtist = boolval($_POST['isArtist']);

if(!$isArtist)
    $artist_members = null;
else
    $artist_members = $_POST['musical_genres'];

$usuario = Usuario::createUser($username, $nickname, $password, $email, $birthdate, $isArtist, $artist_members);

if($usuario) {
    $_SESSION['username'] = $username; 
    header('Location: '.RUTA_VISTAS_PATH.'/foro/Foro.php');
}
else 
    header('Location: '.RUTA_VISTAS_PATH.'/log/SignUpUser.php'); 