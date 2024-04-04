<?php

function generateStaticHeader($currentPage) {
    $iconImage = RUTA_IMG_PATH.'/2MelodyLogo.png';
    $favs = 0;
    $placeholderText = "Ej. usuario: Robert09";
    if (isset($_GET['user'])) {
      $user = $_GET['user']; 
    }
    if (isset($_GET['favs'])) {
      $favs = $_GET['favs']; 
    }
    else if (strpos($currentPage, "/vistas/perfil/Perfil.php") !== false) {
        $placeholderText = "Ej. texto: Hola mundo";
    }

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
        <form action="$currentPage" method="get"> <!-- Action igual a la página actual -->
          <input type="text" name="query" placeholder="$placeholderText">
          <input type="hidden" name="favs" value="$favs">
          <input type="hidden" name="user" value="$user">
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