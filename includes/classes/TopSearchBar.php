<?php
namespace SW\classes;
require_once 'Aplicacion.php';

class TopSearchBar {

    public static $USUARIOS = 'USUARIOS';
    public static $SEGUIDORES = 'SEGUIDORES';
    public static $PLAYLISTS = 'PLAYLISTS';
    public static $CANCIONES = 'CANCIONES';
    public static $PRODUCTOS = 'PRODUCTOS';
    public static $NO_DISPLAY = 'NO_DISPLAY';

    private static $instance = NULL;
    private static $placeHolderText = 'Inicia sesión para buscar';
    private static $userQuery;
    private static $opcion;
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

    public static function searchQuery($data, $opcion){

        // Construimos la consulta SQL
        $conection = Aplicacion::getInstance()->getConexionBd();
        $query = self::buildQuery($data, $opcion);

        // Consulta inválida
        if(!$query)
            return false;

        // Ejecutamos la consulta
        $rs = $conection->query($query);

        // Guardamos la consulta en un array y cerramos la conexión
        $datos = array();
        while($row = $rs->fetch_assoc()) {
            $datos[] = $row;
        }
        $rs->free();

        return $datos;
    }

    // Construimos la consulta SQL
    public static function buildQuery($data, $opcion){

        $html = '';
        switch($opcion){
        case self::$USUARIOS:
            $html = "SELECT * FROM usuario U WHERE U.id_user LIKE '%$data%'";
            break;
        case self::$SEGUIDORES:
            $html = "SELECT id_user FROM seguidores WHERE id_seguidor LIKE '%$data%'";
            break;
        case self::$PLAYLISTS:
            $html = "SELECT * FROM playlist P WHERE P.nombre LIKE '%$data%'";
            break;
        case self::$CANCIONES:
            $html = "SELECT * FROM cancion C WHERE C.titulo LIKE '%$data%'";
            break;
        case self::$PRODUCTOS:
            $html = "SELECT * FROM producto P WHERE P.nombre LIKE '%$data%'";
            break;
        case self::$NO_DISPLAY:
        default:
            $html = false;
            break;
        }

        return $html;
    }

    public static function buscarUsuario(){

        if(!isset($_SESSION['login']))
            return;
        self::$placeHolderText = 'Buscar @usuario';
        self::$opcion = TopSearchBar::$USUARIOS;
    }

    public static function buscarSeguidoresSeguidos(){

        if(!isset($_SESSION['login']))
            return;
        self::$placeHolderText = 'Buscar seguidores/seguidos';
        self::$opcion = TopSearchBar::$SEGUIDORES;
    }

    public static function buscarPlaylists(){

        if(!isset($_SESSION['login']))
            return;
        self::$placeHolderText = 'Buscar playlists';
        self::$opcion = TopSearchBar::$PLAYLISTS;
    }


    public static function buscarCancion(){

        if(!isset($_SESSION['login']))
            return;
        self::$placeHolderText = 'Buscar canción';
        self::$opcion = TopSearchBar::$CANCIONES;
    }

    public static function buscarProductos(){

        if(!isset($_SESSION['login']))
            return;
        self::$placeHolderText = 'Buscar productos';
        self::$opcion = TopSearchBar::$PRODUCTOS;
    }

    public static function notDisplaySearchBar(){
        self::$displaySearchBar = false;
    }

    // Getters
    public static function isInitialized(){ return self::$instance ? true : false; }
    public static function getPlaceHolderText(){ return self::$placeHolderText; }
    public static function getUserQuery(){ return self::$userQuery; }
    public static function getOpcion(){ return self::$opcion; }
    public static function getDisplaySearchBar(){ return self::$displaySearchBar; }
}