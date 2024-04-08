<?php

function generateStaticHeader($currentPage) {

    $iconImage = IMG_PATH . '/2MelodyLogo.png';
    $linkIndex = PROJECT_PATH . '/index.php';
    $favs = 0;
    $placeholderText = "Ej. usuario: Robert09";
    $user = $_GET["user"] ?? NULL;
    if (isset($_GET['user'])) {
      $user = $_GET['user']; 
    }
    if (isset($_GET['favs']) && $_GET['favs'] == 1) {
      $favs = $_GET['favs']; 
    }
    else if (strpos($currentPage, "/vistas/perfil/Perfil.php") !== false) {
        $placeholderText = "Ej. texto: Buena foto";
    }
    else if (strpos($currentPage, "/vistas/tienda/Merch.php") !== false) {
      $placeholderText = "Ej. producto: Camiseta";
  }

    if (!islogged()) {
        $loginImage = IMG_PATH . '/FotoLoginUser.png';
        $altText = 'Foto de login';
        $link = VIEWS_PATH . '/log/Login.php';
        $texto = "Iniciar sesión";
    } else {
        $loginImage = IMG_PATH . '/FotoLogoutUser.png';
        $altText = 'Foto de logout';
        $link = VIEWS_PATH . '/log/Logout.php';
        $username = $_SESSION['username'];
        $texto = "Bienvenido " . $username; 
    }

    $html = <<<EOS
    <header class= 'header'>
      <a href="$linkIndex">
        <img src = '$iconImage' alt="Logo App" height="50" width="75">
      </a>
      <p>
        <form action="$currentPage" method="get"> <!-- Action igual a la página actual -->
          <input type="text" name="query" placeholder="$placeholderText">
          <input type="hidden" name="favs" value="$favs">
          <input type="hidden" name="user" value="$user">
          <button type="submit">&#128269</button>
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