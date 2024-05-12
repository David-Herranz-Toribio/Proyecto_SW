<?php
namespace SW\classes;
require_once 'Cancion.php';


class Playlist{

    public static $DEFAULT_PLAYLIST = 'Favoritos';

    private $id_playlist;
    private $id_usuario;
    private $duracion;
    private $imagen;
    private $nombre;
    private $creationDate;
    private $numCanciones;

    
    private function __construct($parameters){

        $this->id_playlist = $parameters['id_playlist'];
        $this->id_usuario = $parameters['id_usuario'];
        $this->duracion = $parameters['duracion'];
        $this->imagen = $parameters['imagen'];
        $this->nombre = $parameters['nombre'];
        $this->creationDate = $parameters['creationDate'];
    }


    public static function crearPlaylistPorDefecto($autor, $creationDate){

        $defaultImage = 'playlist_fav.png';
        return Playlist::crearPlaylistBD($autor, Playlist::$DEFAULT_PLAYLIST, $defaultImage, $creationDate);
    }

    public static function obtenerPlaylistsBD($username){

        $playlists = [];
        $conection = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf( "SELECT * FROM playlist P WHERE P.id_user = '%s' ORDER BY P.nombre ASC", $username);
        $rs = $conection->query($query);
        
        if(!$rs)
            return NULL;

        while($fila = $rs->fetch_assoc()){

            $parameters = [];
            $parameters['id_playlist'] = $fila['id_playlist'];
            $parameters['id_usuario'] = $fila['id_user'];
            $parameters['duracion'] = $fila['duracion_total'];
            $parameters['imagen'] = $fila['imagen'];
            $parameters['nombre'] = $fila['nombre'];
            $parameters['creationDate'] = $fila['fecha'];

            $playlists[] = new Playlist($parameters);
        }
        $rs->free();

        return $playlists;
    }

    public static function obtenerPlaylistByID($id){

        $playlist = '';
        $conection = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf( "SELECT * FROM playlist P WHERE P.id_playlist = '%s' ORDER BY P.fecha DESC", $id);
        $rs = $conection->query($query);
        
        if(!$rs)
            return false;

        while($fila = $rs->fetch_assoc()){

            $parameters = [];
            $parameters['id_playlist'] = $fila['id_playlist'];
            $parameters['id_usuario'] = $fila['id_user'];
            $parameters['duracion'] = $fila['duracion_total'];
            $parameters['imagen'] = $fila['imagen'];
            $parameters['nombre'] = $fila['nombre'];
            $parameters['creationDate'] = $fila['fecha'];

            $playlist = new Playlist($parameters);
        }
        $rs->free();

        return $playlist;
    }

    public static function crearPlaylistBD($autor, $nombre, $imagen, $creationDate){

        $conection = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO playlist (id_user, duracion_total, imagen, nombre, fecha) 
        VALUES ('%s', '%d', '%s', '%s', '%s')", $conection->real_escape_string($autor), 0, $conection->real_escape_string($imagen), $conection->real_escape_string($nombre), $creationDate);
        $rs = $conection->query($query);
        
        if($rs){}
        else error_log($conection->error); 

        return $rs;
    }


    public function borrarPlaylist(){
        if($this->imagen!= 'playlist1.jpg'){
            unlink(IMG_URL . '/songImages/'. $this->imagen); 
        }

        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM playlist WHERE id_playlist = %d", $this->id_playlist);

        $result = $conn->query($query);

        if (!$result)  
            error_log($conn->error);

        return $result;
    }
    
    public static function existeNombrePlaylist($id_user, $nombre_playlist){

        $result = false;
        $conection = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT nombre FROM playlist P WHERE P.id_user = '%s' AND P.nombre = '%s'", $id_user, $nombre_playlist);
        $rs = $conection->query($query);

        if($rs->fetch_assoc()){
            $rs->free();
            $result = true;
        }

        return $result;
    }

    public static function eliminarPlaylist($id_playlist){

        $conection = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM playlist WHERE id_playlist = '%s'", $id_playlist);
        $rs = $conection->query($query);

        return $rs;
    }


    public static function actualizar($playlist){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
    
        $query = sprintf(
            "UPDATE playlist SET nombre= '%s', imagen= '%s' WHERE id_playlist = %d",
            $conn->real_escape_string($playlist->nombre),
            is_null($playlist->imagen) ? 'NULL' : $conn->real_escape_string($playlist->imagen),
            $playlist->id_playlist
        );
    
        $result = $conn->query($query);
    
        if (!$result) 
            error_log($conn->error);
        else if ($conn->affected_rows != 1) 
            error_log("Se han actualizado '$conn->affected_rows' registros!");
    
        return $result;
    }

    public function addCancion($id_cancion){
            
        $conection = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO play_cancion (id_playlist, id_cancion) VALUES ('%d', '%d')", $this->id_playlist, $id_cancion);
        $rs = $conection->query($query);

        return $rs;
    }

    public function quitarCancion($id_cancion){

        $conection = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM play_cancion WHERE id_playlist = '%s' AND id_cancion = '%s'", $this->id_playlist, $id_cancion);
        $rs = $conection->query($query);

        return $rs;
    }

    public function getIdPlaylist(){
        return $this->id_playlist;
    }

    public function getIdUsuario(){
        return $this->id_usuario;
    }

    public function getPlaylistDuracion(){
        return $this->duracion;
    }

    public function getPlaylistImagen(){
        return $this->imagen;
    }

    public function getPlaylistNombre(){
        return $this->nombre;
    }

    public function getPlaylistCreationDate(){
        return $this->creationDate;
    }

    public function getPlaylistNumSongs(){
        return $this->numCanciones;
    }

    public function setPlaylistNombre($nombre){
        $this->nombre= $nombre; 
    }

    public function setPlaylistImagen($img){
        $this->imagen= $img; 
    }
}