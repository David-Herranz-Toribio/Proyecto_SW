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


    public function __construct($parameters){

        $this->id_cancion = 'id';
        $this->id_artista = 'fg';
        $this->titulo = 'sdfg';
        $this->imagen = 'sdfg';
        $this->fecha = 'sdfg';
        $this->duracion = 'sfg';
        $this->likes = 'sdfgf';
        $this->ruta = 'sdfhh';
        $this->tags = 'sfhfgh';

        /*
        $this->id_cancion = $parameters['id_cancion'];
        $this->id_artista = $parameters['id_artista'];
        $this->titulo = $parameters['titulo'];
        $this->imagen = $parameters['imagen'];
        $this->fecha = $parameters['fecha'];
        $this->duracion = $parameters['duracion'];
        $this->likes = $parameters['likes'];
        $this->ruta = $parameters['ruta'];
        $this->tags = $parameters['tags'];
        */
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