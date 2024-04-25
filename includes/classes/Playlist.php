<?php

namespace es\ucm\fdi\aw;

require_once 'Aplicacion.php';

class Playlist{

    private $name;
    private $autor;
    private $songList;
    private $totalLenght;
    private $creationDate;

    public function __construct($parameters){

        $this->name = $parameters['name'];
        $this->autor = $parameters['autor'];
        $this->songList = [];
        $this->totalLenght = 0;
        $this->creationDate = $parameters['creationDate'];
    }

    public static function obtenerPlaylistsBD($username){

        $playlists = [];

        // Obtener las playlists del usuario de la base de datos

        return $playlists;
    }

    public function getName(){
        return $this->name;
    }

    public function getAutor(){
        return $this->autor;
    }

    public function getSongList(){
        return $this->songList;
    }

    public function getTotalLenght(){
        return $this->totalLenght;
    }

    public function getCreationDate(){
        return $this->creationDate;
    }

}