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
        return;
        $this->id_cancion = $parameters['id_cancion'];
        $this->id_artista = $parameters['id_artista'];
        $this->titulo = $parameters['titulo'];
        $this->imagen = $parameters['imagen'];
        $this->fecha = $parameters['fecha'];
        $this->duracion = $parameters['duracion'];
        $this->likes = $parameters['likes'];
        $this->ruta = $parameters['ruta'];
        $this->tags = $parameters['tags'];
    }



    public function getIdCancion(){
        return $this->id_cancion;
    }

    public function getIdArtista(){
        return $this->id_artista;
    }

    public function getTitulo(){
        return $this->titulo;
    }

    public function getImagen(){
        return $this->imagen;
    }

    public function getFecha(){
        return $this->fecha;
    }

    public function getDuracion(){
        return $this->duracion;
    }

    public function getLikes(){
        return $this->likes;
    }

    public function getRuta(){
        return $this->ruta;
    }

    public function getTags(){
        return $this->tags;
    }

}