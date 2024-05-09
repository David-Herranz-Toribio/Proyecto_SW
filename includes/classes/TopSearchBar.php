<?php
namespace SW\classes;
require_once 'Aplicacion.php';

class TopSearchBar {

    private static $instance = NULL;
    private $placeHolderText = 'Inicia sesión para buscar';
    private $query = '';
    private $displaySearchBar = true;

    // Evitar el creación de múltiples instancias
    private function __construct(){}

	public static function getInstance() {

		if (self::$instance == NULL) {
			self::$instance = new static();
		}
		return self::$instance;
    }

    public function logOut(){
        self::$instance = NULL;
    }

    public function buscarUsuario(){

        if(!isset($_SESSION['login']))
            return;
        $this->placeHolderText = 'Buscar @usuario';
        $this->query = "";
    }

    public function buscarSeguidoresSeguidos(){

        if(!isset($_SESSION['login']))
            return;
        $this->placeHolderText = 'Buscar seguidores/seguidos';
        $this->query = "";
    }

    public function buscarPlaylists(){

        if(!isset($_SESSION['login']))
            return;
        $this->placeHolderText = 'Buscar playlists';
        $this->query = "";
    }

    public function buscarCancionEnPLaylist(){

        if(!isset($_SESSION['login']))
            return;
        $this->placeHolderText = 'Buscar canción en playlist';
        $this->query = "";
    }

    public function buscarCancion(){

        if(!isset($_SESSION['login']))
            return;
        $this->placeHolderText = 'Buscar canción';
        $this->query = "";
    }

    public function buscarPedidos(){

        if(!isset($_SESSION['login']))
            return;
        $this->placeHolderText = 'Buscar pedidos';
        $this->query = "";
    }

    public function buscarProductos(){

        if(!isset($_SESSION['login']))
            return;
        $this->placeHolderText = 'Buscar productos';
        $this->query = "";
    }

    public function notDisplaySearchBar(){
        $this->displaySearchBar = false;
    }

    public function isInitialized(){ return $this->instance ? true : false; }
    public function getPlaceHolderText(){ return $this->placeHolderText; }
    public function getQuery(){ return $this->query; }
    public function getDisplaySearchBar(){ return $this->displaySearchBar; }
}