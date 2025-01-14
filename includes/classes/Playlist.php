<?php
namespace SW\classes;
require_once 'Cancion.php';


class Playlist{

    public static $DEFAULT_PLAYLIST = 'Favoritos';

    private $id_playlist;
    private $id_usuario;
    private $imagen;
    private $nombre;
    private $creationDate;
    private $numCanciones;

    
    private function __construct($parameters){

        $this->id_playlist = $parameters['id_playlist'];
        $this->id_usuario = $parameters['id_usuario'];
        $this->imagen = $parameters['imagen'];
        $this->nombre = $parameters['nombre'];
        $this->creationDate = $parameters['creationDate'];
    }


    public static function crearPlaylistPorDefecto($autor, $creationDate){

        $defaultImage = 'playlist_fav.png';
        return self::crearPlaylistBD($autor, Playlist::$DEFAULT_PLAYLIST, $defaultImage, $creationDate);
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
        $query = sprintf( "SELECT * FROM playlist P WHERE P.id_playlist = %d ORDER BY P.fecha DESC", $id);
        $rs = $conection->query($query);
        
        if(!$rs)
            return false;

        while($fila = $rs->fetch_assoc()){

            $parameters = [];
            $parameters['id_playlist'] = $fila['id_playlist'];
            $parameters['id_usuario'] = $fila['id_user'];
            $parameters['imagen'] = $fila['imagen'];
            $parameters['nombre'] = $fila['nombre'];
            $parameters['creationDate'] = $fila['fecha'];

            $playlist = new Playlist($parameters);
        }
        $rs->free();

        return $playlist;
    }

    public static function obtenerPlaylistFav($playlistName, $user){
        $playlist = '';
        $conection = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf( "SELECT * FROM playlist P  WHERE P.nombre = '%s' AND P.id_user= '%s' ORDER BY P.fecha DESC", 
        $conection->real_escape_string($playlistName),
        $conection->real_escape_string($user)
        );
        
        $rs = $conection->query($query);
        
        if(!$rs)
            return false;

        while($fila = $rs->fetch_assoc()){

            $parameters = [];
            $parameters['id_playlist'] = $fila['id_playlist'];
            $parameters['id_usuario'] = $fila['id_user'];
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
        $query = sprintf("INSERT INTO playlist (id_user,  imagen, nombre, fecha) 
        VALUES ('%s', '%s', '%s', '%s')", $conection->real_escape_string($autor), $conection->real_escape_string($imagen), $conection->real_escape_string($nombre), $creationDate);
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

    public function yaPuesta($id_cancion){

        $conection = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM play_cancion WHERE id_playlist = '%d' AND id_cancion = '%d'", $this->id_playlist, $id_cancion);
        $rs = $conection->query($query);

        if($rs->fetch_assoc()){
            $rs->free();
            return true;
        }

        return false;
    }


    public function comprobarNombreCancion($nombre){ //Esta funcion comprueba que cuando un artista añade una cancion, no haya ninguna previamente con el mismo nombre 
        $conection = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM cancion C
        JOIN play_cancion P ON C.id_cancion = P.id_cancion
        WHERE P.id_playlist= %d AND C.titulo= '%s'", $this->id_playlist, $conection->real_escape_string($nombre)); 

        $rs = $conection->query($query);

        if($rs->fetch_assoc()){
            $rs->free();
            return true;
        }

        return false;
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