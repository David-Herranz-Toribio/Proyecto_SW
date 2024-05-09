<?php

require_once '../../Config.php';


// Barra de búsqueda para usuarios seguidos y seguidores
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->buscarUsuario();

unset($_SESSION['username']);
unset($_SESSION['login']);
unset($_SESSION['isArtist']);
unset($_SESSION['isAdmin']);
unset($_SESSION['isSub']);

session_destroy();
session_start();
header('Location:' . VIEWS_PATH . '/foro/Foro.php'); 