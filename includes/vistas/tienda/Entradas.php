<?php

require_once '../../Config.php';

$content = showProfile();

require_once LAYOUT_PATH;

function showProfile(){
    
    $html = "<p> Estas viendo la tienda de eventos</p>";

    return $html;
}
