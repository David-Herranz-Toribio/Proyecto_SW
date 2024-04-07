<?php
require_once '../Config.php';
require_once RUTA_CLASSES.'/Usuario.php'; 

$id_user= $_POST['id_user']; 
$nickname = htmlspecialchars($_POST['modify_nickname']);
$descripcion= htmlspecialchars($_POST['modify_descrip']); 
$email = htmlspecialchars($_POST['modify_email']);

$password = $_POST['modify_password'];


$birthdate = $_POST['modify_birthdate'];

$usu_mod= Usuario::buscaUsuario($id_user); 
if($nickname) $usu_mod->setNickname($nickname);

if($descripcion) $usu_mod->setDescrip($descripcion); 

if($email) $usu_mod->setEmail($email);

if($password){
    $password= password_hash($password, PASSWORD_DEFAULT);
    $usu_mod->setPassword($password);
} 

if($birthdate) $usu_mod->setBirthdate($birthdate);

Usuario:: actualiza($usu_mod); 

header('Location: '.RUTA_VISTAS_PATH.'/perfil/Perfil.php'); 