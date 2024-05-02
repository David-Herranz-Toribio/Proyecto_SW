<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/ExplorarCancionesHelper.php';

$id_user = 'user2';
$content = displaySongsFromArtist($id_user);

require_once LAYOUT_URL;