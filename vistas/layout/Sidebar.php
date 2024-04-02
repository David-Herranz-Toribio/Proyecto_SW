<nav class= "sidebar">
    <dl class= "opciones">
        <dt class="perfil_shortcut">
            <a href="<?=RUTA_VISTAS_PATH?>/perfil/Perfil.php">
                <img src="<?=RUTA_IMG_PATH?>/FotoPerfil.png" height="50" width="50" alt="Foto perfil">
            </a>
            <details>
                <summary>
                    Opciones:
                </summary>
                <dd><a href="<?=RUTA_VISTAS_PATH?>/perfil/Perfil.php?favs=1">Posts Favoritos</a></dd>

            </details>
        </dt>
        <dt class="foro_shorcut">
            <a href="<?=RUTA_VISTAS_PATH?>/foro/Foro.php">
                <img src="<?=RUTA_IMG_PATH?>/FotoForo.png" height="50" width="50" alt="Foto de foro">
            </a>
            <!--  <details>
                <summary>
                    Opciones:
                </summary>
                <dd><a href="<?=RUTA_VISTAS_PATH?>/foro/CrearPost.php">Publicar post</a></dd>
            </details> -->
        </dt>

        <dt class="musica_shorcut">
            <a href="<?=RUTA_VISTAS_PATH?>/musica/Musica.php">
                <img src="<?=RUTA_IMG_PATH?>/FotoMusica.png" height="40" width="50" alt="Foto de musica">
            </a>
            <details>
                <summary>
                    Opciones:                    
                </summary>
                <dd>Opción 1 de música</dd>
                <dd>Opción 2 de música</dd>
            </details>
        </dt>
        <dt class="tienda_shorcut">
            <a href="<?=RUTA_VISTAS_PATH?>/tienda/Merch.php">
                <img src="<?=RUTA_IMG_PATH?>/FotoTienda.png" height="50" width="50" alt="Foto de tienda">
            </a>
        <details>
            <summary>
                Opciones: 
            </summary>
            <dd><a href="<?=RUTA_VISTAS_PATH?>/tienda/Entradas.php"><img src="<?=RUTA_IMG_PATH?>/FotoEntrada.png" height="50" width="50" alt="Foto de eventos"></a></dd>
            <dd><a href="<?=RUTA_VISTAS_PATH?>/tienda/Merch.php"><img src="<?=RUTA_IMG_PATH?>/FotoMerch.png" height="50" width="50" alt="Foto de merchandising"></a></dd>
            <dd><a href="<?=RUTA_VISTAS_PATH?>/tienda/Carrito.php"><img src="<?=RUTA_IMG_PATH?>/FotoCarrito.png" height="50" width="50" alt="Foto de mi carrito"></a></dd>
        </details>
        </dt>
    </dl>
</nav>