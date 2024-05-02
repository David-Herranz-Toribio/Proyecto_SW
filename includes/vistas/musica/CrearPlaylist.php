<?php

require_once '../../Config.php';
require_once CLASSES_URL . '/FormularioCrearPlaylist.php';

$username = '';
if(isset($_GET['user']) && isset($_SESSION['username']) && $_GET['user'] == $_SESSION['username'])
    $username = htmlspecialchars($_GET['user'], ENT_QUOTES);


$form = new FormularioCrearPlaylist($username);
$formHTML = $form->gestiona();

$content =<<<EOS
<section class="createPlaylistForm">
    $formHTML
</section>
EOS;

require_once LAYOUT_URL;