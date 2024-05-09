<?php
require_once '../../Config.php';


function generateStaticHeader($currentPage) {

	// Texto de la barra de búsqueda vacío
	$searchBar = SW\classes\TopSearchBar::getInstance();

	// Resto de icones y textos
	$iconImage = IMG_PATH . '/2MelodyLogo.png';
	$linkIndex = PROJECT_PATH . '/index.php';
	$placeholderText = $searchBar->getPlaceHolderText();
	$user = $_GET["user"] ?? isset($_SESSION['username']) ? $_SESSION['username'] : NULL;
	$opcion = $_GET["opcion"] ?? NULL;
	$username = '';

	if (!islogged()) {
		$loginImage = IMG_PATH . '/FotoLoginUser.png';
		$altText = 'Foto de login';
		$link = VIEWS_PATH . '/log/Login.php';
		$texto = "Iniciar sesión";
		$onclick = "location.assign('$link');";
	}
	else {
		$loginImage = IMG_PATH . '/FotoLogoutUser.png';
		$altText = 'Foto de logout';
		$link = VIEWS_PATH . '/log/Logout.php';
		$username = $_SESSION['username'];
		$texto = "Bienvenido " . $username; 
		if(isset($_SESSION['isSub'])){
			$susImg = IMG_PATH . '/FotoSuscrito.png';
			$texto .= <<<EOS2
				<img src='$susImg' alt='Simbolo Suscrito' height='25' width='30' class='simboloSuscrito'>
			EOS2;
		}
		$onclick = "comprobar();";
	}

	$html = <<<EOS
	<header class= 'header'>
	<a href="$linkIndex">
		<img src = '$iconImage' alt="Logo App" height="50" width="75">
	</a>
	EOS;

	// Vistas que no muestran la barra de búsqueda
	if (isset($_SESSION['login']) && $searchBar->getDisplaySearchBar()){

		$html .= <<<EOS
		<p>
		<form action="$currentPage" method="get"> <!-- Action igual a la página actual -->
			<input type="text" name="query" placeholder="$placeholderText">
			<input type="hidden" name="user" value="$user">
			<input type="hidden" name="opcion" value="$opcion">
			<button type="submit"> &#128269 </button>
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