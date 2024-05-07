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


    public static function crearCancion($titulo, $imagen, $fecha, $ruta, $tags){

        $parameters = [];
        return new Cancion($parameters);
    }

    public static function getSongsFromPlaylistID($id_playlist){

        $canciones = [];
        $conection = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf( "SELECT * FROM play_cancion P JOIN cancion C ON P.id_cancion = C.id_cancion WHERE P.id_playlist = '%s'", $id_playlist);
        $rs = $conection->query($query);

        if(!$rs){
            return false;
        }

        while($fila = $rs->fetch_assoc()){

            $parameters = [];
            $parameters['id_cancion'] = $fila['id_cancion'];
            $parameters['titulo'] = $fila['titulo'];
            $parameters['imagen'] = $fila['imagen'];
            $parameters['fecha'] = $fila['fecha'];
            $parameters['id_artista'] = $fila['id_artista'];
            $parameters['likes'] = $fila['likes'];
            $parameters['ruta'] = $fila['ruta'];
            $parameters['duracion'] = $fila['duracion'];
            $parameters['tags'] = $fila['tags'];

            $canciones[] = new Cancion($parameters);
        }
        $rs->free();

        return $canciones;
    }

    public static function obtenerCancionesDeArtista($id_artista){
        
        $canciones = [];
        $conection = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf( "SELECT * FROM cancion C WHERE C.id_artista = '%s'", $id_artista);
        $rs = $conection->query($query);
        
        if(!$rs)
            return false;

        while($fila = $rs->fetch_assoc()){

            $parameters = [];
            $parameters['id_cancion'] = $fila['id_cancion'];
            $parameters['titulo'] = $fila['titulo'];
            $parameters['imagen'] = $fila['imagen'];
            $parameters['fecha'] = $fila['fecha'];
            $parameters['id_artista'] = $fila['id_artista'];
            $parameters['likes'] = $fila['likes'];
            $parameters['ruta'] = $fila['ruta'];
            $parameters['duracion'] = $fila['duracion'];
            $parameters['tags'] = $fila['tags'];

            $canciones[] = new Cancion($parameters);
        }
        $rs->free();

        return $canciones;
    }

    public function crearCancionBD(){

        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO cancion (id_cancion, titulo, imagen, fecha, id_artista, likes, ruta, duracion, tags) 
            VALUES ('%s','%s','%s','%d','%s','%s','%s', '%s', '%s')",);

        $result = $conn->query($query);

        if (!$result)
            error_log($conn->error);          

        return $result;
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