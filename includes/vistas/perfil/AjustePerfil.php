<?php
require_once '../../Config.php';
require_once CLASSES_URL . '/Usuario.php'; 
require_once CLASSES_URL . '/FormularioModificacionPerfil.php'; 
require_once HELPERS_URL . '/AjustePerfilHelper.php';


// Selección de barra dee búsqueda y visibilidad
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->notDisplaySearchBar();

// Variables de la vista
$perfil = SW\classes\Usuario::buscaUsuario($_SESSION['username']);
$image = IMG_PATH . '/profileImages/' . $perfil->getPhoto();

// Generar HTML
$content = displayImagenPerfil($image);
$content .= displayBotonesEliminarCuenta();
$content .= displayFormularioModificar();

$scripts = ['eventos.js']; 

require_once LAYOUT_URL; 


