<?php

function generateStaticHeader() {
    $iconImage = RUTA_IMG_PATH.'/2MelodyLogo.png';

    if (!islogged()) {
        $loginImage = RUTA_IMG_PATH.'/FotoLoginUser.png';
        $altText = 'Foto de login';
        $link = RUTA_VISTAS_PATH.'/log/Login.php';
        $texto = "Iniciar sesión";
    } else {
        $loginImage = RUTA_IMG_PATH.'/FotoLogoutUser.png';
        $altText = 'Foto de logout';
        $link = RUTA_VISTAS_PATH.'/log/Logout.php';
        $username = $_SESSION['username'];
        $texto = "Bienvenido " . $username; 
    }

    $html = <<<EOS
    <header class= 'header'>
        <p>
            <img src = '$iconImage' alt="Logo app" height="50" width="75">
        </p>
        <p>

        <form action="busqueda.php" method="get">
        <input type="text" name="query" placeholder="Ej. usuario: Robert09">
        <button type="submit">Buscar</button>
        </form>
        </p>


        <div class= 'info_session'> 
          <div class= 'contenedor_texto'> 
            <p>
            $texto
            <p> 
          </div> 

          <div class= 'contenedor_imagen'> 
            <p> <a href="$link"><img src="$loginImage" height="30" width="30" alt="$altText"></a> <p> 
          </div> 
        </div> 
    </header>
    EOS;

    return $html;
}

function islogged(){
    return isset($_SESSION['username']);
}