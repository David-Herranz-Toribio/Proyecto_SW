<?php

require_once 'Config.php';

$content = showProfile();

require_once 'Layout.php';

function showProfile(){
    
    $html = "<p> Estas viendo tu carrito </p>";

    return $html;
}
