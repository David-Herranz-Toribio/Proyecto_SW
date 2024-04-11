<?php
require_once '../Config.php';
require_once CLASSES_URL . '/Usuario.php'; 

$id_user= $_POST['id_user']; 
$nickname = htmlspecialchars($_POST['modify_nickname']);
$descripcion= htmlspecialchars($_POST['modify_descrip']); 
$email = htmlspecialchars($_POST['modify_email']);

$password = $_POST['modify_password'];

$usu_mod= es\ucm\fdi\aw\Usuario::buscaUsuario($id_user); 
if($nickname) $usu_mod->setNickname($nickname);

if($descripcion) $usu_mod->setDescrip($descripcion); 

if($email) $usu_mod->setEmail($email);

if($password){
    $password= password_hash($password, PASSWORD_DEFAULT);
    $usu_mod->setPassword($password);
} 

es\ucm\fdi\aw\Usuario::actualiza($usu_mod); 

header('Location: '. VIEWS_PATH .'/perfil/Perfil.php'); 