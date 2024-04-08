

<nav class="sidebar">
    <ul class="opciones">
        <li>
            <a href="<?=RUTA_VISTAS_PATH?>/perfil/Perfil.php">
                <img src="<?=RUTA_IMG_PATH?>/FotoPerfil.png" height="50" width="50" alt="Foto perfil">
            </a>
            <ul class="desplegable">
                <li><a href="<?=RUTA_VISTAS_PATH?>/perfil/Perfil.php?favs=1">Posts Favoritos</a></li>
            </ul>
        </li>
        <li>
            <a href="<?=RUTA_VISTAS_PATH?>/foro/Foro.php">
                <img src="<?=RUTA_IMG_PATH?>/FotoForo.png" height="50" width="50" alt="Foto de foro">
            </a>
        </li>
        <li>
            <a href="<?=RUTA_VISTAS_PATH?>/musica/Musica.php">
                <img src="<?=RUTA_IMG_PATH?>/FotoMusica.png" height="40" width="50" alt="Foto de musica">
            </a>
            <ul class="desplegable">
                <li>Opción 1 de música</li>
                <li>Opción 2 de música</li>
            </ul>
        </li>
        <li>
            <a href="<?=RUTA_VISTAS_PATH?>/tienda/Merch.php">
                <img src="<?=RUTA_IMG_PATH?>/FotoTienda.png" height="50" width="50" alt="Foto de tienda">
            </a>
            <ul class="desplegable">
                <li><a href="<?=RUTA_VISTAS_PATH?>/tienda/Entradas.php"><img src="<?=RUTA_IMG_PATH?>/FotoEntrada.png" height="50" width="50" alt="Foto de eventos"></a></li>
                <li><a href="<?=RUTA_VISTAS_PATH?>/tienda/Merch.php"><img src="<?=RUTA_IMG_PATH?>/FotoMerch.png" height="50" width="50" alt="Foto de merchandising"></a></li>
            </ul>
        </li>
        <li>
            <a href="<?=RUTA_VISTAS_PATH?>/tienda/Carrito.php"><img src="<?=RUTA_IMG_PATH?>/FotoCarrito.png" height="50" width="50" alt="Foto de mi carrito"></a>
            <div id="cantPedido">
                <div id="numberProd"><?=isset($_SESSION['notif_prod']) ? $_SESSION['notif_prod'] : 0;?></div>
            </div>
        </li>
    </ul>
</nav>
