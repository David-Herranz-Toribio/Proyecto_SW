<?php
require_once '../../Config.php';



function generateStaticHeader($currentPage) {

	// Obtener los datos de la barra de búsqueda
	$searchOption = \SW\classes\TopSearchBar::getOpcion();

	// Ruta pestaña de la searchbar
	$searchbarPage = VIEWS_PATH . '/searchBar/SearchBarView.php';

	// Resto de icones y textos
	$iconImage = IMG_PATH . '/2MelodyLogo.png';
	$linkIndex = PROJECT_PATH . '/index.php';
	$placeholderText = \SW\classes\TopSearchBar::getPlaceHolderText();
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
				<img class='logoSubs' src='$susImg' alt='Simbolo Suscrito' height='25' width='30' class='simboloSuscrito'>
			EOS2;
		}
		$onclick = "comprobar();";
	}

	$html = <<<EOS
	<header class= 'header'>
	<a class='logoApp' href="$linkIndex">
		<img src = '$iconImage' alt="Logo App" height="50" width="75">
	</a>
	EOS;

	// Vistas que no muestran la barra de búsqueda
	if (isset($_SESSION['login']) && \SW\classes\TopSearchBar::getDisplaySearchBar()){

		$html .= <<<EOS
		<form class='searchBar' action='$searchbarPage' method='get'>	
			<input class='searchInput' type="text" name="data" placeholder="$placeholderText">
			<input type="hidden" name="searchOption" value='$searchOption'>
			<button type="submit"> &#128269 </button>
		</form>
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

	<div class='session'>
		<div class= 'info_session'> 
			<div class= 'contenedor_texto'> 
				<p> $texto </p>
			</div> 
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