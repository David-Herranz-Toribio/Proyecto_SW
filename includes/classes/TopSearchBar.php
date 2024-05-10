<?php
namespace SW\classes;
require_once 'Aplicacion.php';

class TopSearchBar {

    private static $instance = NULL;
    private static $placeHolderText = 'Inicia sesión para buscar';
    private static $table;
    private static $filters;
    private static $userQuery;
    private static $displaySearchBar = true;

    // Evitar la creación de múltiples instancias
    private function __construct(){}

	public static function getInstance() {

		if (self::$instance == NULL) {
			self::$instance = new static();
		}
		return self::$instance;
    }

    public static function logOut(){
        self::$instance = NULL;
    }

    public static function searchQuery($table, $filters, $data){

        // Construimos la consulta SQL
        $conection = Aplicacion::getInstance()->getConexionBd();
        $query = $table . " " . $filters . " '" . $data . "%'";
        $rs = $conection->query($query);

        // Guardamos la consulta en un array
        $datos = $rs->fetch_assoc();
        $rs->free();

        return $datos;
    }

    public static function buscarUsuario(){

        if(!isset($_SESSION['login']))
            return;
        self::$placeHolderText = 'Buscar @usuario';
        self::$table = "SELECT * FROM usuario U";
        self::$filters = "WHERE U.id_user LIKE";
    }

    public static function buscarSeguidoresSeguidos(){

        if(!isset($_SESSION['login']))
            return;
        self::$placeHolderText = 'Buscar seguidores/seguidos';
        self::$table = "SELECT * FROM seguidores S";
        self::$filters = "WHERE S.usuario LIKE";
    }

    public static function buscarPlaylists(){

        if(!isset($_SESSION['login']))
            return;
        self::$placeHolderText = 'Buscar playlists';
        self::$table = "SELECT * FROM playlist P";
        self::$filters = "WHERE P.nombre LIKE";
    }

    public static function buscarCancionEnPlaylist(){

        if(!isset($_SESSION['login']))
            return;
        self::$placeHolderText = 'Buscar canción en playlist';
        self::$table = "SELECT * FROM play_cancion C";
        self::$filters = "WHERE C.nombre LIKE";
    }

    public static function buscarCancion(){

        if(!isset($_SESSION['login']))
            return;
        self::$placeHolderText = 'Buscar canción';
        self::$table = "SELECT * FROM cancion C";
        self::$filters = "WHERE C.nombre LIKE";
    }

    public static function buscarPedidos(){

        if(!isset($_SESSION['login']))
            return;
        self::$placeHolderText = 'Buscar pedidos';
        self::$table = "SELECT * FROM pedido P";
        self::$filters = "WHERE P.id LIKE";
    }

    public static function buscarProductos(){

        if(!isset($_SESSION['login']))
            return;
        self::$placeHolderText = 'Buscar productos';
        self::$table = "SELECT * FROM producto P";
        self::$filters = "WHERE P.nombre LIKE";
    }

    public static function notDisplaySearchBar(){
        self::$displaySearchBar = false;
    }

    // Getters
    public static function isInitialized(){ return self::$instance ? true : false; }
    public static function getPlaceHolderText(){ return self::$placeHolderText; }
    public static function getTable(){ return self::$table; }
    public static function getFilters(){ return self::$filters; }
    public static function getUserQuery(){ return self::$userQuery; }
    public static function getDisplaySearchBar(){ return self::$displaySearchBar; }
}