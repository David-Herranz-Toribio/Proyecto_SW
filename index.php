<?php
require_once "Config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=RUTA_CSS_PATH?>/estilos.css">
    <title> 2Music </title>
</head>

<body>
    
    <main>
        <div id='tituloIndex'>
            <h1>Bienvenido a 2Melody</h1>
            <img src='<?=RUTA_IMG_PATH?>/2MelodyLogo.png' height="300" width="500" alt="Foto Logo app">
        </div>
        
        <div id='presentacion'>
            <h2><strong>¿Qué somos?</strong></h2>
            <p class='textoIndex'>
                2Melody es una nueva red social diseñada específicamente para los apasionados de la música
                en todo el mundo. En 2Melody, nos esforzamos por crear un espacio único donde los aficionados
                a la música pueden conectarse, explorar y descubrir nuevas experiencias musicales.
            </p>

            <div id='sang1'>
                <h2><strong>Explora y Disfruta</strong></h2>
                <p class='textoIndex'>
                    En 2Melody, te invitamos a sumergirte en un océano de contenido musical diverso y emocionante.
                    Explora una amplia variedad de publicaciones compartidas por artistas y usuarios, 
                    desde actualizaciones de conciertos hasta adelantos de nuevas canciones. 
                    Navega por nuestras listas de reproducción y descubre nuevas canciones y artistas.
                </p>
            </div>
            
            <div id='sang2'>
                <h2><strong>Más que Música</strong></h2>
                <p class='textoIndex'>
                    2Melody es mucho más que una plataforma de música. Además de disfrutar de tus canciones favoritas, 
                    también puedes comprar exclusivo merchandising de tus artistas favoritos, desde camisetas y pósters 
                    hasta vinilos y ediciones especiales de álbumes. Conecta con otros aficionados, comparte tus opiniones 
                    y descubre nuevas joyas musicales mientras te sumerges en la vibrante comunidad de 2Melody.
                </p>
            </div>
        </div>

        <img src='<?=RUTA_IMG_PATH?>/Pentagrama.png' height="100" width="100%" alt="Foto Logo app">

        <p id='txtFinalIndx'>
            ¿A qué esperas? Únete a nosotros en 2Melody y haz que tu experiencia musical
            sea más emocionante, interactiva y enriquecedora que nunca. Pincha en los enlaces de abajo y comienza 
            esta nueva aventura.
        </p>
        
        
        <div id='enlacesIndex'>
            <a href="<?=RUTA_VISTAS_PATH?>/perfil/Perfil.php">
                <img src='<?=RUTA_IMG_PATH?>/FotoPerfil.png' height="200" width="200" alt="Foto Perfil">
            </a>

            <a href="<?=RUTA_VISTAS_PATH?>/foro/Foro.php">
                <img src='<?=RUTA_IMG_PATH?>/FotoForo.png' height="200" width="200" alt="Foto Foro">
            </a>

            <a href="<?=RUTA_VISTAS_PATH?>/musica/Musica.php">
                    <img src="<?=RUTA_IMG_PATH?>/FotoMusica.png" height="200" width="200" alt="Foto Musica">
            </a>

            <a href="<?=RUTA_VISTAS_PATH?>/tienda/Merch.php">
                <img src='<?=RUTA_IMG_PATH?>/FotoTienda.png' height="200" width="200" alt="Foto Tienda">
            </a>
        </div>

    </main>
</body>
</html>