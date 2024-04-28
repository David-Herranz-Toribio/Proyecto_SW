<?php

namespace SW\classes;

class Cancion{

    private $id_cancion;
    private $id_artista;
    private $titulo;
    private $imagen;
    private $fecha;
    private $duracion;
    private $likes;
    private $ruta;
    private $tags;


    private function __construct($parameters){

        $this->id_cancion = $parameters['id'];
        $this->id_artista = $parameters['fg'];
        $this->titulo = $parameters['sdfg'];
        $this->imagen = $parameters['sdfg'];
        $this->fecha = $parameters['sdfg'];
        $this->duracion = $parameters['sfg'];
        $this->likes = $parameters['sdfgf'];
        $this->ruta = $parameters['sdfhh'];
        $this->tags = $parameters['sfhfgh'];
    }

    public static function createSong(){

        $parameters = [];
        return new Cancion($parameters);
    }

    public static function getSongsWithID(){

        $canciones = [];
        return $canciones;
    }

    public function getIdCancion(){
        return $this->id_cancion;
    }

    public function getIdArtista(){
        return $this->id_artista;
    }

    public function getCancionTitulo(){
        return $this->titulo;
    }

    public function getCancionImagen(){
        return $this->imagen;
    }

    public function getCancionFecha(){
        return $this->fecha;
    }

    public function getCancionDuracion(){
        return $this->duracion;
    }

    public function getCancionLikes(){
        return $this->likes;
    }

    public function getCancionRuta(){
        return $this->ruta;
    }

    public function getCancionTags(){
        return $this->tags;
    }

}