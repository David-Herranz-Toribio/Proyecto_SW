<?php

require_once '../../Config.php';
require_once CLASSES_URL . '/FormularioCrearAlbum.php';

$username = '';
if(isset($_GET['user']) && isset($_SESSION['username']) && $_GET['user'] == $_SESSION['username'])
    $username = htmlspecialchars($_GET['user'], ENT_QUOTES);

$form = new FormularioCrearAlbum($username);
$content = "<section class='formCrearAlbum'>";
$content .= $form->gestiona();
$content .= "</section>";

require_once LAYOUT_URL;