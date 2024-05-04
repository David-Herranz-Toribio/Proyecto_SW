<?php

namespace SW\classes;

use ReflectionFunction;

require_once 'Cancion.php';

class Playlist{

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

        $defaultImage = 'defaultPlaylist.jpg';
        return Playlist::crearPlaylistBD($autor, 'Favoritos', $defaultImage, $creationDate);
    }

    public static function obtenerPlaylistsBD($username){

        $playlists = [];
        $conection = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf( "SELECT * FROM playlist P WHERE P.id_user = '%s' ORDER BY P.fecha DESC", $username);
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
        VALUES ('%s', '%d', '%s', '%s', '%s')", $autor, 0, $imagen, $nombre, $creationDate);
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

}