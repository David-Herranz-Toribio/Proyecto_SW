<?php
    require_once 'Config.php'; 

    unset($_SESSION['username']); 
    unset($_SESSION['login']); 

    session_destroy(); 
    session_start(); 
    header('Location: Foro.php'); 
?>