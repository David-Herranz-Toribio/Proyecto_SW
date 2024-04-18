<?php 

require_once '../Config.php';
require_once CLASSES_URL . '/Usuario.php';
$user = null;

if(isset($_SESSION['username']))
    $user = $_SESSION['username'];

$isValid = true;

if($isValid && $user){
    es\ucm\fdi\aw\Usuario::deleteUser($user);
}
header('Location:'. VIEWS_PATH .'/log/Logout.php');