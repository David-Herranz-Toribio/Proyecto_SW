<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/MusicaHelper.php';

$username = isset($_SESSION['username']) ? $_SESSION['username'] : NULL;
$content = '';

if(isset($_SESSION['username']))
    $content = showPlaylists($username);
else
    $content .= displayViewToNotLogged();

require_once LAYOUT_URL;