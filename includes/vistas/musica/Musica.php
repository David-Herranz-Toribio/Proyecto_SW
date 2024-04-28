<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/MusicaHelper.php';

$username_id = 1;
$content = '';

if(isset($_SESSION['username']))
    $content = showPlaylists($username_id);
else
    $content = displayViewToNotLogged();

require_once LAYOUT_URL;