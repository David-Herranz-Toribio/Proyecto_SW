<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/PlaylistViewHelper.php';

// Obtener el id de la playlist seleccionada por el usuario
$playlist_id = 1;

// Mostrar el contenido de la playlist
$content = displayPlaylist($playlist_id);

require_once LAYOUT_URL;