<?php
require_once '../Config.php';
require_once CLASSES_URL . '/Usuario.php'; 

$id_user= $_POST['id_user']; 
$nickname = htmlspecialchars($_POST['modify_nickname']);
$descripcion= htmlspecialchars($_POST['modify_descrip']); 
$email = htmlspecialchars($_POST['modify_email']);

$password = $_POST['modify_password'];

$usu_mod= es\ucm\fdi\aw\Usuario::buscaUsuario($id_user); 

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
    $usu_mod->setPhoto($profile_image);
}
if($nickname) $usu_mod->setNickname($nickname);

if($descripcion) $usu_mod->setDescrip($descripcion); 

if($email) $usu_mod->setEmail($email);

if($password){
    $password= password_hash($password, PASSWORD_DEFAULT);
    $usu_mod->setPassword($password);
} 

es\ucm\fdi\aw\Usuario::actualiza($usu_mod); 

header('Location: '. VIEWS_PATH .'/perfil/Perfil.php'); 