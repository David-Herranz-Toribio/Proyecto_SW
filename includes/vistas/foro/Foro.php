<?php

require_once '../../../Config.php';
require_once HELPERS_URL . '/PostHelper.php';

$yo = isset($_SESSION['username']) ? $_SESSION['username'] : null;

$content = showTestPosts($yo);

require_once LAYOUT_URL;