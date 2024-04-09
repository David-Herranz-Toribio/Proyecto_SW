<nav class="sidebar">
    <ul class="opciones">
        <li>
            <a href="<?=VIEWS_PATH?>/perfil/Perfil.php">
                <img src="<?=IMG_PATH?>/FotoPerfil.png" height="50" width="50" alt="Foto perfil">
            </a>
            <ul class="desplegable">
                <li><a href="<?=VIEWS_PATH?>/perfil/Perfil.php?favs=1">Posts Favoritos</a></li>
            </ul>
        </li>

        <li>
            <a href="<?=VIEWS_PATH?>/foro/Foro.php">
                <img src="<?=IMG_PATH?>/FotoForo.png" height="50" width="50" alt="Foto de foro">
            </a>
        </li>

        <li>
            <a href="<?=VIEWS_PATH?>/musica/Musica.php">
                <img src="<?=IMG_PATH?>/FotoMusica.png" height="40" width="50" alt="Foto de musica">
            </a>
            <ul class="desplegable">
                <li>Opt 1</li>
                <li>Opt 2</li>
            </ul>
        </li>

        <li>
            <a href="<?=VIEWS_PATH?>/tienda/Merch.php">
                <img src="<?=IMG_PATH?>/FotoTienda.png" height="50" width="50" alt="Foto de tienda">
            </a>
            <ul class="desplegable">
                <li><a href="<?=VIEWS_PATH?>/tienda/Entradas.php"><img src="<?=IMG_PATH?>/FotoEntrada.png" height="50" width="50" alt="Foto de eventos"></a></li>
                <?php if(isset($_SESSION['isArtist']) && $_SESSION['isArtist'] ){ ?>
                    <li><a href="<?=VIEWS_PATH?>/tienda/Merch.php"><img src="<?=IMG_PATH?>/FotoMerch.png" height="50" width="50" alt="Foto de merchandising"></a></li>
                <?php } ?>
            </ul>
        </li>

        <li>
            <a href="<?=VIEWS_PATH?>/tienda/Carrito.php"><img src="<?=IMG_PATH?>/FotoCarrito.png" height="50" width="50" alt="Foto de mi carrito"></a>
            <?php if(isset($_SESSION['notif_prod']) && $_SESSION['notif_prod'] != 0 ){ ?>
                <div id="cantPedido">
                    <div id="numberProd"><?=$_SESSION['notif_prod']?></div>
                </div>
            <?php } ?>

        </li>
    </ul>
</nav>
