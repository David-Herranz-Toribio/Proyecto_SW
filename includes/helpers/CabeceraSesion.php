<?php

function generateStaticHeader($currentPage) {

  $iconImage = IMG_PATH . '/2MelodyLogo.png';
  $linkIndex = PROJECT_PATH . '/index.php';
  $placeholderText = "Ej. usuario: Robert09";
  $user = $_GET["user"] ?? isset($_SESSION['username']) ? $_SESSION['username'] : NULL;
  $opcion = $_GET["opcion"] ?? NULL;
  $username = '';

  if ($opcion !== 'FAVS' && strpos($currentPage, "/vistas/perfil/Perfil.php") !== false) {
    $placeholderText = "Ej. texto: Buena foto";
  }
  if ($opcion == 'PRODUCTS' || strpos($currentPage, "/vistas/tienda/Merch.php") !== false) {
    $placeholderText = "Ej. producto: Camiseta";
  }
  else if ($opcion == 'ORDERS') {
    $placeholderText = "Ej. fecha: yyyy-mm-dd";
  }

  if (!islogged()) {
    $loginImage = IMG_PATH . '/FotoLoginUser.png';
    $altText = 'Foto de login';
    $link = VIEWS_PATH . '/log/Login.php';
    $texto = "Iniciar sesión";
    $onclick = "location.assign('$link');";
  } else {
    $loginImage = IMG_PATH . '/FotoLogoutUser.png';
    $altText = 'Foto de logout';
    $link = VIEWS_PATH . '/log/Logout.php';
    $username = $_SESSION['username'];
    $texto = "Bienvenido " . $username; 
    $onclick = "comprobar();";
  }

  $html = <<<EOS
<header class= 'header'>
  <a href="$linkIndex">
    <img src = '$iconImage' alt="Logo App" height="50" width="75">
  </a>
EOS;

if (strpos($currentPage, "/vistas/perfil/AjustePerfil.php") === false && strpos($currentPage, "/vistas/foro/RespuestasForo.php") === false) {
  $html .= <<<EOS
  <p>
    <form action="$currentPage" method="get"> <!-- Action igual a la página actual -->
      <input type="text" name="query" placeholder="$placeholderText">
      <input type="hidden" name="user" value="$user">
      <input type="hidden" name="opcion" value="$opcion">
      <button type="submit">&#128269</button>
    </form>
  </p>
EOS;
}

$html .= <<<EOS
<script>
function comprobar() {
  var ok = window.confirm("¿Quieres cerrar sesión, $username?");
  if (ok)
    location.assign("$link");
}
</script>
</head>
<body>

<div class= 'info_session'> 
  <div class= 'contenedor_texto'> 
    <p> $texto </p>
  </div> 

  <div class= 'contenedor_imagen'> 
    <p><a href="#" onclick="$onclick"><img src="$loginImage" height="30" width="30" alt="$altText"></a></p> 
  </div> 
</div> 
</header>
EOS;


  return $html;
}

function islogged(){
  return isset($_SESSION['username']);
}