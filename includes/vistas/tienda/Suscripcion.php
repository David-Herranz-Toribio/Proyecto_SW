<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/TiendaHelper.php';

$yo = isset($_SESSION['username']) ? $_SESSION['username'] : null;
$content = "<section class='default'>";

$content .= <<<EOS
<div>
    <h1>2Melody Premium</h1>
    <button id='sub_button' type="submit">Pásate a premium</button>
</div>
<h2>Experiencia sin límites</h2>
<p>Con 2Melody Premium podrás disfrutar de todas tus canciones sin interrupciones, así como grandes
descuentos en los productos de tus artistas favoritos, personalización avanzada y mucho más</p>
EOS;


require_once LAYOUT_URL;