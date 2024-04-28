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
        $this->creationDate = $parameters['creationDate'];
        $this->songList = $parameters['songList'];
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
            $parameters['songList'] = NULL;

            $playlists[] = new Playlist($parameters);
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

    public function getPlaylistSongList(){
        return $this->songList;
    }

}