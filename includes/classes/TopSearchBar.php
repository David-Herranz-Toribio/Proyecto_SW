<?php
namespace SW\classes;
require_once 'Aplicacion.php';

class TopSearchBar {

    private static $instance;
    private $placeHolderText = '';
    private $query = '';


    // Evitar el creación de múltiples instancias
    private function __construct(){}

	public static function getInstance() {

		if (!self::$instance instanceof self) {
			self::$instance = new static();
		}
		return self::$instance;
    }

    public static function logOut(){
        self::$instance = NULL;
    }

    public function loggedOut(){
        $this->placeHolderText = 'Inicia sesión';
        $this->query = "";
    }
    
    public function buscarUsuario(){
        $this->placeHolderText = 'Buscar @usuario';
        $this->query = "";
    }

    public function buscaArtista(){
        $this->placeHolderText = 'Buscar @artista';
        $this->query = "";
    }

    public function buscaCancion(){
        $this->placeHolderText = '@Buscar canción';
        $this->query = "";
    }

    public function buscaAlbum(){
        $this->placeHolderText = 'Buscar album';
        $this->query = "";
    }

    public function buscarPedidos(){
        $this->placeHolderText = 'Buscar pedidos';
        $this->query = "";
    }

    public function isInitialized(){ return $this->instance ? true : false; }
    public function getPlaceHolderText(){ return $this->placeHolderText; }
    public function getQuery(){ return $this->query; }
}