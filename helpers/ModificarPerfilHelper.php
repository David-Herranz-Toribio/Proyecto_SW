<?php
require_once '../Config.php';
require_once RUTA_CLASSES.'/Usuario.php'; 

$id_user= $_POST['id_user']; 
$nickname = htmlspecialchars($_POST['modify_nickname']);
$email = htmlspecialchars($_POST['modify_email']);
$password = password_hash($_POST['modify_password'], PASSWORD_DEFAULT);
$birthdate = $_POST['modify_birthdate'];

$usu_mod= Usuario::buscaUsuario($id_user); 
if($nickname) $usu_mod->setNickname($nickname);

if($email) $usu_mod->setEmail($email);

if($password) $usu_mod->setPassword($password);

if($birthdate) $usu_mod->setBirthdate($birthdate);

Usuario:: actualiza($usu_mod); 

header('Location: '.RUTA_VISTAS_PATH.'/perfil/Perfil.php'); 