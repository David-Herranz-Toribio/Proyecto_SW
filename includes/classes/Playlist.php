<?php

namespace SW\classes;

class Playlist{

    private $id_playlist;
    private $id_usuario;
    private $duracion;
    private $imagen;
    private $nombre;
    private $creationDate;
    private $songList;

    
    private function __construct($parameters){

        $this->id_playlist = $parameters['id_playlist'];
        $this->id_usuario = $parameters['id_usuario'];
        $this->duracion = $parameters['duracion'];
        $this->imagen = $parameters['imagen'];
        $this->nombre = $parameters['nombre'];
        $this->creationDate = $parameters['fechaCreacion'];
        $this->songList = $parameters['canciones'];
    }

    public static function obtenerPlaylistsBD($username){

        $playlists = [];
        $conection = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf( "SELECT * FROM playlist P WHERE P.id_user = '%s' ORDER BY P.fecha DESC", $username);
        $rs = $conection->query($query);
        
        while($fila = $rs->fetch_assoc()){
            $parameters = [];
            
            $playlists[] = new Cancion($parameters);
        }
        $rs->free();

        return $playlists;
    }

    public function getIdPlaylist(){
        return $this->id_playlist;
    }

    public function getIdUsuario(){
        return $this->id_usuario;
    }

    public function getDuracion(){
        return $this->duracion;
    }

    public function gtImagen(){
        return $this->imagen;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getCreationDate(){
        return $this->creationDate;
    }

    public function getSongList(){
        return $this->songList;
    }

}