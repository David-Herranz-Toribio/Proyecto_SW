<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/MusicaHelper.php';

$username_id = 1;

$content = showPlaylists($username_id);

require_once LAYOUT_URL;